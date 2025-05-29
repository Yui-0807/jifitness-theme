<?php
// 注册自定义 REST API 路由
add_action('rest_api_init', function () {
    // 获取所有训练目标
    register_rest_route('wp/v2', '/ji-training-goal', array(
        'methods' => 'GET',
        'callback' => 'get_training_goals_api',
        'permission_callback' => '__return_true'
    ));
    
    // 获取推荐课程
    register_rest_route('wp/v2', '/recommended-courses', array(
        'methods' => 'GET',
        'callback' => 'get_recommended_courses_api',
        'permission_callback' => '__return_true',
        'args' => array(
            'course_type' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return in_array($param, ['ji-1-on-1', 'ji-small-group']);
                }
            ),
            'primary_goal' => array(
                'required' => true,
                'validate_callback' => 'is_numeric'
            ),
            'secondary_goal' => array(
                'required' => false,
                'validate_callback' => 'is_numeric'
            )
        )
    ));
});

// 获取训练目标的 API 回调
function get_training_goals_api() {
    $goals = get_terms(array(
        'taxonomy' => 'ji-training-goal',
        'hide_empty' => false,
    ));
    
    $formatted_goals = array();
    
    if ($goals && !is_wp_error($goals)) {
        foreach ($goals as $goal) {
            $formatted_goals[] = array(
                'id' => $goal->term_id,
                'name' => $goal->name,
                'description' => $goal->description ?: '',
                'slug' => $goal->slug
            );
        }
    }
    
    return new WP_REST_Response($formatted_goals, 200);
}

// 获取推荐课程的 API 回调
function get_recommended_courses_api($request) {
    $course_type = sanitize_text_field($request->get_param('course_type'));
    $primary_goal = intval($request->get_param('primary_goal'));
    $secondary_goal = $request->get_param('secondary_goal') ? intval($request->get_param('secondary_goal')) : null;
    
    // 构建 tax_query
    $tax_query = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'ji-training-goal',
            'field' => 'term_id',
            'terms' => $primary_goal
        )
    );
    
    if ($secondary_goal) {
        $tax_query[] = array(
            'taxonomy' => 'ji-training-goal',
            'field' => 'term_id',
            'terms' => $secondary_goal,
            'operator' => 'IN'
        );
    }
    
    $args = array(
        'post_type' => $course_type,
        'posts_per_page' => -1,
        'tax_query' => $tax_query
    );
    
    $courses_query = new WP_Query($args);
    
    $courses = array();
    
    if ($courses_query->have_posts()) {
        while ($courses_query->have_posts()) {
            $courses_query->the_post();
            
            $goal_terms = get_the_terms(get_the_ID(), 'ji-training-goal');
            $goal_names = array();
            
            if ($goal_terms && !is_wp_error($goal_terms)) {
                foreach ($goal_terms as $term) {
                    $goal_names[] = $term->name;
                }
            }
            
            $courses[] = array(
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'link' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'type' => $course_type,
                'goals' => $goal_names
            );
        }
        wp_reset_postdata();
    }
    
    return new WP_REST_Response($courses, 200);
}