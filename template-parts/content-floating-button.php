<?php

// Floating Button
?>
<!-- Scroll to Top Btn -->
<button id="scroll-top" class="scroll-top">
    Top
    <span class="screen-reader-text">Scroll To Top</span>
</button>

<button class="toggle-btn" aria-label="Toggle floating menu">
    <span class="bar bar1"></span>
    <span class="bar bar2"></span>
</button>

<div class="floating-menu">
    

    <!-- Form and Line Btn -->
    <?php
    $menu = wp_get_nav_menu_object('footer-social-media');

    if (have_rows('social_media', $menu)) {
        while (have_rows('social_media', $menu)) {
            the_row();

            $social_media_links = get_sub_field('social_media_links');
            $category = get_sub_field('category');
            $line_svg = file_get_contents(get_template_directory() . '/images/line.php');
            
            if($category === 'google-form'){
                echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">預約諮詢與體驗課</a>';
            }
            if($category === 'line'){
                echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">'. $line_svg . '</a>';
            }
        }
    }?>
</div>

