<?php

// Floating Button

$menu = wp_get_nav_menu_object('footer-social-media');

if (have_rows('social_media', $menu)) {
    while (have_rows('social_media', $menu)) {
        the_row();

        $title = get_sub_field('title');
        $social_media_links = get_sub_field('social_media_links');
        $category = get_sub_field('category');
        $line_svg = file_get_contents(get_template_directory() . '/images/line.php');
        
        if($category === 'google-form'){
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">' . esc_html($title) . '</a>';
        }
        if($category === 'line'){
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">'. $line_svg . '</a>';
        }
    }
}