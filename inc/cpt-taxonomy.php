<?php
//php tag should be line 1


function ji_register_custom_post_types() {
    
    // Register Testimonials CPT
    $labels = array(
        'name'               => _x( 'Testimonials', 'post type general name' ),
        'singular_name'      => _x( 'Testimonials', 'post type singular name' ),
        'menu_name'          => _x( 'Testimonials', 'admin menu' ),
        'name_admin_bar'     => _x( 'Testimonials', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Testimonials'  ),
        'add_new_item'       => __( 'Add New Testimonials'  ),
        'new_item'           => __( 'New Testimonials' ),
        'edit_item'          => __( 'Edit Testimonials' ),
        'view_item'          => __( 'View Testimonials' ),
        'all_items'          => __( 'All Testimonials'  ),
        'search_items'       => __( 'Search Testimonials' ),
        'parent_item_colon'  => __( 'Parent Testimonials:' ),
        'not_found'          => __( 'No Testimonials found.' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash.' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonials'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => array( 'title', 'thumbnail', 'editor' )
    );

    register_post_type( 'ji-testimonials', $args );

    //Register 1-on-1 CPT
    $labels = array(
        'name'               => _x( '1-on-1', 'post type general name' ),
        'singular_name'      => _x( '1-on-1', 'post type singular name' ),
        'menu_name'          => _x( '1-on-1', 'admin menu' ),
        'name_admin_bar'     => _x( '1-on-1', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', '1-on-1'  ),
        'add_new_item'       => __( 'Add New 1-on-1'  ),
        'new_item'           => __( 'New 1-on-1' ),
        'edit_item'          => __( 'Edit 1-on-1' ),
        'view_item'          => __( 'View 1-on-1' ),
        'all_items'          => __( 'All 1-on-1'  ),
        'search_items'       => __( 'Search 1-on-1' ),
        'parent_item_colon'  => __( 'Parent 1-on-1:' ),
        'not_found'          => __( 'No 1-on-1 found.' ),
        'not_found_in_trash' => __( 'No 1-on-1 found in Trash.' ),
    );
     
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => '1-on-1'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array( 'title' )
    );
     
    register_post_type( 'ji-1-on-1', $args );


    //Register Small Group CPT
    $labels = array(
        'name'               => _x( 'Small Group', 'post type general name' ),
        'singular_name'      => _x( 'Small Group', 'post type singular name' ),
        'menu_name'          => _x( 'Small Group', 'admin menu' ),
        'name_admin_bar'     => _x( 'Small Group', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'service'  ),
        'add_new_item'       => __( 'Add New Small Group'  ),
        'new_item'           => __( 'New Small Group' ),
        'edit_item'          => __( 'Edit Small Group' ),
        'view_item'          => __( 'View Small Group' ),
        'all_items'          => __( 'All Small Group'  ),
        'search_items'       => __( 'Search Small Group' ),
        'parent_item_colon'  => __( 'Parent Small Group:' ),
        'not_found'          => __( 'No Small Group found.' ),
        'not_found_in_trash' => __( 'No Small Group found in Trash.' ),
    );
     
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'small-group'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title' )
    );
     
    register_post_type( 'ji-small-group', $args );
    
}
add_action( 'init', 'ji_register_custom_post_types' );



function ji_register_taxonomies() {

    //we can use taxonomy array above repeatly on different page. (post type key)
    // Add 1-on-1 Training Goal taxonomy.
    $labels = array(
        'name'              => _x( 'Training Goal', 'taxonomy general name' ),
        'singular_name'     => _x( 'Training Goal', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Training Goal' ),
        'all_items'         => __( 'All Training Goals' ),
        'parent_item'       => __( 'Training Goal Featured' ),
        'parent_item_colon' => __( 'Training Goal Featured:' ),
        'edit_item'         => __( 'Edit Training Goal' ),
        'update_item'       => __( 'Update Training Goal' ),
        'add_new_item'      => __( 'Add New Training Goal' ),
        'new_item_name'     => __( 'New Work Training Goal' ),
        'menu_name'         => __( 'Training Goal' ),
    );
    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'training-goal' ),
    );
    register_taxonomy( 'ji-training-goal', array( 'ji-1-on-1','ji-small-group',), $args );

    // Add Delivery Method to 1-on-1 and small-group taxonomy.
    $labels = array(
        'name'              => _x( 'Delivery Method', 'taxonomy general name' ),
        'singular_name'     => _x( 'Delivery Method', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Delivery Method' ),
        'all_items'         => __( 'All Delivery Methods' ),
        'parent_item'       => __( 'Delivery Method Featured' ),
        'parent_item_colon' => __( 'Delivery Method Featured:' ),
        'edit_item'         => __( 'Edit Delivery Method' ),
        'update_item'       => __( 'Update Delivery Method' ),
        'add_new_item'      => __( 'Add New Delivery Method' ),
        'new_item_name'     => __( 'New Work Delivery Method' ),
        'menu_name'         => __( 'Delivery Method' ),
    );
    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'delivery-method' ),
    );
    register_taxonomy( 'ji-delivery-method', array( 'ji-1-on-1','ji-small-group',), $args );


}
add_action( 'init', 'ji_register_taxonomies');


function ji_rewrite_flush() {
    ji_register_custom_post_types();
    ji_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ji_rewrite_flush' );