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

    $exclusion_rules = [
        [
            'delivery' => null,
            'terms' => ['防身技巧'],
            'exclude_posts' => [52],
        ],
        [
            'delivery' => null,
            'terms' => ['癌後體適能運動'],
            'exclude_posts' => [14],
        ],
        [
            'delivery' => null,
            'terms' => ['增加核心肌耐力', '敏捷協調能力'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => null,
            'terms' => ['體態雕塑', '敏捷協調能力'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => null,
            'terms' => ['增加肌力與肌肉量', '敏捷協調能力'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => null,
            'terms' => ['增加核心肌耐力', '增肌減脂'],
            'exclude_posts' => [51],
        ],
        [
            'delivery' => null,
            'terms' => ['體態雕塑', '增肌減脂'],
            'exclude_posts' => [51],
        ],
        [
            'delivery' => null,
            'terms' => ['增加核心肌耐力', '癌後體適能運動'],
            'exclude_posts' => [51],
        ],
        [
            'delivery' => null,
            'terms' => ['體態雕塑', '癌後體適能運動'],
            'exclude_posts' => [51],
        ],
        [
            'delivery' => null,
            'terms' => ['敏捷協調能力', '癌後體適能運動'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => 'online',
            'terms' => ['敏捷協調能力', '增加心肺功能'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => 'online',
            'terms' => ['敏捷協調能力', '體態雕塑'],
            'exclude_posts' => [51],
        ],
        [
            'delivery' => 'online',
            'terms' => ['敏捷協調能力', '增肌減脂'],
            'exclude_posts' => [62],
        ],
        [
            'delivery' => 'online',
            'terms' => ['敏捷協調能力'],
            'exclude_posts' => [62],
        ],
    ];    

    $excluded_post_ids = [];

    // 取得選取需求的 term name
    $selected_names = [];
    if ($primary_goal) {
        $primary_term = get_term($primary_goal, 'ji-training-goal');
        if ($primary_term && !is_wp_error($primary_term)) {
            $selected_names[] = $primary_term->name;
        }
    }
    if ($secondary_goal) {
        $secondary_term = get_term($secondary_goal, 'ji-training-goal');
        if ($secondary_term && !is_wp_error($secondary_term)) {
            $selected_names[] = $secondary_term->name;
        }
    }

    foreach ($exclusion_rules as $rule) {
        $rule_delivery = $rule['delivery'];
        $combo_terms = $rule['terms'];
        $excluded_posts = $rule['exclude_posts'];
    
        // 判斷 delivery 是否 match
        $delivery_match = is_null($rule_delivery) || ($delivery_method === $rule_delivery);
    
        // 判斷 goals 是否 match
        $goals_match = count(array_intersect($combo_terms, $selected_names)) == count($combo_terms);
    
        if ($delivery_match && $goals_match) {
            $excluded_post_ids = array_merge($excluded_post_ids, $excluded_posts);
        }
    }
      

    // 支援單一類型或全部類型
    $post_types = !empty($course_type)
        ? [$course_type]
        : ['ji-1-on-1', 'ji-small-group'];

    // tax_query
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

    // WP Query args
    $args = [
        'post_type'      => $post_types,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'tax_query'      => $tax_query,
        'post__not_in'   => $excluded_post_ids, // 排除邏輯加進來
    ];

    $query = new WP_Query($args);

    $courses = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $post_type = get_post_type($post_id);

            $terms = get_the_terms($post_id, 'ji-training-goal');
            $goal_names = !is_wp_error($terms) && !empty($terms)
                ? wp_list_pluck($terms, 'name')
                : [];

            $delivery_terms = get_the_terms($post_id, 'ji-delivery-method');
            $delivery_names = !is_wp_error($delivery_terms) && !empty($delivery_terms)
                ? wp_list_pluck($delivery_terms, 'name')
                : [];

            // ACF 內容
            $full_description = wp_strip_all_tags(get_field('class_description'));
            $short_description = mb_substr($full_description, 0, 60) . '...';

            $courses[] = [
                'id' => $post_id,
                'title' => get_the_title(),
                'goals' => $goal_names,
                'description' => $short_description,
                'type' => $post_type,
                'delivery_methods' => $delivery_names,
                'category_link' => $post_type === 'ji-1-on-1' ? home_url('/1-on-1') : home_url('/small-group'),
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
