<?php

// Floating Button

$menu = wp_get_nav_menu_object('footer-social-media');

if (have_rows('social_media', $menu)) {
    while (have_rows('social_media', $menu)) {
        the_row();

        $title = get_sub_field('title');
        $social_media_links = get_sub_field('social_media_links');
        $category = get_sub_field('category');
        
        if($category === 'Google Form'){
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">' . esc_html($title) . '</a>';
        }
        if($category === 'Line'){
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">'.get_template_part('images/line'). '</a>';
        }
    }
}