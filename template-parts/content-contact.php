<?php

// About Us page - Contact Information

$menu = wp_get_nav_menu_object('footer-social-media');

$address = get_field('address', $menu);
$phone = get_field('phone', $menu);
$email = get_field('email', $menu);
$line_id = get_field('line_id', $menu); 

if ($address) {
    echo '<div class="contact-item">';
    get_template_part('images/map');
    echo '<span>場館位置 Address</span>';
    echo '<p>' . esc_html($address) . '</p></div>';
}

if ($phone) {
    echo '<div class="contact-item">';
    get_template_part('images/phone');
    echo '<span>聯絡電話 Phone</span>';
    echo '<p>' . esc_html($phone) . '</p></div>';
}

if ($email) {
    echo '<div class="contact-item">';
    get_template_part('images/email');
    echo '<span>聯絡信箱 Mail</span>';
    echo '<p>' . esc_html($email) . '</p></div>';
}

if ($line_id && isset($line_id['line_qrcode']['url'])) {
    echo '<div class="contact-item">';
    get_template_part('images/line');
    echo '<span>官方Line ID</span>';
    echo '<p>' . esc_html($line_id['user_line_id'] ?? '') . '</p>';
    echo '<img src="' . esc_url($line_id['line_qrcode']['url']) . '" alt="' . esc_attr($line_id['line_qrcode']['alt'] ?? '') . '" /></div>';
}

if (have_rows('social_media', $menu)) {
    while (have_rows('social_media', $menu)) {
        the_row();

        $title = get_sub_field('title');
        $social_media_links = get_sub_field('social_media_links');
        $category = get_sub_field('category');
       
        if($category === 'facebook'){
            echo '<div class="contact-item">';
            get_template_part('images/facebook');
            echo '<span>Facebook官方粉專</span>';  
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">' . esc_html($title) . '</a></div>';
        }

        if($category === 'instagram'){
            echo '<div class="contact-item">';
            get_template_part('images/instagram');
            echo '<span>Instagram官方帳號</span>';
            echo '<a href="' . $social_media_links . '" target="_blank" rel="noopener noreferrer">' . esc_html($title) . '</a></div>';
           
        }
        
    }
}