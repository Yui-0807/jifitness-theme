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

function ji_get_recommended_courses( WP_REST_Request $request ) {
    $course_type = $request->get_param('course_type');
    $primary_goal = $request->get_param('primary_goal');
    $secondary_goal = $request->get_param('secondary_goal');

    $tax_query = [
        'relation' => 'OR',  // 改成 OR，代表「包含其中一個即可」
    ];

    if ($primary_goal) {
        $tax_query[] = [
            'taxonomy' => 'ji-training-goal',
            'field' => 'term_id',
            'terms' => [$primary_goal],
        ];
    }

    if ($secondary_goal) {
        $tax_query[] = [
            'taxonomy' => 'ji-training-goal',
            'field' => 'term_id',
            'terms' => [$secondary_goal],
        ];
    }

    $args = [
        'post_type' => 'ji_course',
        'post_status' => 'publish',
        'tax_query' => $tax_query,
        'meta_query' => [
            [
                'key' => 'course_type',
                'value' => $course_type,
                'compare' => '='
            ]
        ],
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);

    $courses = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $courses[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'description' => get_the_excerpt(),
            ];
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($courses);
}

