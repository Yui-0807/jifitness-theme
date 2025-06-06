<?php
/**
 * 注册自定义REST API端点
 */
add_action('rest_api_init', function() {
    // 获取训练目标端点
    register_rest_route('ji/v1', '/training-goals', array(
        'methods' => 'GET',
        'callback' => 'ji_get_training_goals',
        'permission_callback' => '__return_true'
    ));
    
    // 获取推荐课程端点
    register_rest_route('ji/v1', '/recommended-courses', array(
        'methods' => 'GET',
        'callback' => 'ji_get_recommended_courses',
        'permission_callback' => '__return_true',
        'args' => array(
            'course_type' => array(
                'required' => false,
                'validate_callback' => function($param) {
                    if (is_array($param)) {
                        return !array_diff($param, ['ji-1-on-1', 'ji-small-group']);
                    }
                    return in_array($param, ['ji-1-on-1', 'ji-small-group']);
                }
            ),
            'primary_goal' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric($param);
                }
            ),
            'secondary_goal' => array(
                'required' => false,
                'validate_callback' => function($param, $request, $key) {
                    return $param === '' || is_numeric($param);
                }
            ),'delivery_method' => array(
                'required' => false,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            ),
            
            
        )
    ));

    register_rest_route('ji/v1', '/delivery-methods', array(
        'methods' => 'GET',
        'callback' => 'ji_get_delivery_methods',
        'permission_callback' => '__return_true'
    ));
    
});

/**
 * 获取训练目标回调函数
 */
function ji_get_training_goals() {
    $goals = get_terms(array(
        'taxonomy' => 'ji-training-goal',
        'hide_empty' => false,
    ));
    
    $formatted = array();
    
    if (!is_wp_error($goals)) {
        foreach ($goals as $goal) {
            $formatted[] = array(
                'id' => $goal->term_id,
                'name' => $goal->name,
                'description' => $goal->description ?: '',
                'slug' => $goal->slug
            );
        }
    }
    
    return rest_ensure_response($formatted);
}

function ji_get_recommended_courses(WP_REST_Request $request) {
    $course_type = $request->get_param('course_type');
    $primary_goal = $request->get_param('primary_goal');
    $secondary_goal = $request->get_param('secondary_goal');
    $delivery_method = $request->get_param('delivery_method');

    $goals = array_filter([$primary_goal, $secondary_goal]);

    // 支援單一類型或全部類型（兩種 post type）
    $post_types = ($course_type === 'ji-1-on-1' || $course_type === 'ji-small-group')
        ? [$course_type]
        : ['ji-1-on-1', 'ji-small-group'];

        $tax_query = [];

        if (!empty($goals)) {
            $tax_query[] = [
                'taxonomy' => 'ji-training-goal',
                'field' => 'term_id',
                'terms' => $goals,
                'operator' => 'IN'
            ];
        }
    
        if (!empty($delivery_method)) {
            $tax_query[] = [
                'taxonomy' => 'ji-delivery-method',
                'field' => 'slug',
                'terms' => $delivery_method,
                'operator' => 'IN'
            ];
        }

        $args = [
            'post_type'      => $post_types,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => $tax_query,
        ];

    $query = new WP_Query($args);

    $courses = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
    
            $terms = get_the_terms(get_the_ID(), 'ji-training-goal');
            $goal_names = !is_wp_error($terms) && !empty($terms)
                ? wp_list_pluck($terms, 'name')
                : [];

            $delivery_terms = get_the_terms(get_the_ID(), 'ji-delivery-method');
            $delivery_names = !is_wp_error($delivery_terms) && !empty($delivery_terms)
                ? wp_list_pluck($delivery_terms, 'name')
                : [];

    
            $courses[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'goals' => $goal_names,
                'description' => get_the_excerpt(),
                'type' => get_post_type(),
                'permalink' => get_permalink(),
                'delivery_methods' => $delivery_names,

            ];
        }
        wp_reset_postdata();
    }    

    return rest_ensure_response($courses);
}

function ji_get_delivery_methods() {
    $methods = get_terms(array(
        'taxonomy' => 'ji-delivery-method',
        'hide_empty' => false,
    ));

    $formatted = [];

    if (!is_wp_error($methods)) {
        foreach ($methods as $method) {
            $formatted[] = array(
                'id' => $method->term_id,
                'name' => $method->name,
                'slug' => $method->slug,
                'description' => $method->description ?: ''
            );
        }
    }

    return rest_ensure_response($formatted);
}
