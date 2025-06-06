<?php

// custom footer menu - social media

add_filter('wp_nav_menu_items', 'my_wp_nav_menu_items', 10, 2);

function my_wp_nav_menu_items( $items, $args ) {
    
    // get menu
    $menu = wp_get_nav_menu_object($args->menu);

    // === Footer Middle (Repeater) ===
    if ($args->theme_location === 'footer-social-media') {
        $social_items = '';

        if (have_rows('social_media', $menu)) {
			while (have_rows('social_media', $menu)) {
				the_row();
				
				// Get subfields
				$title = get_sub_field('title');
				$category = get_sub_field('category');
				$link = get_sub_field('social_media_links');

				// Prepare fallback values
				$link_url = !empty($link) ? esc_url($link) : '#';
		
				// Start output buffering to capture template part output
				ob_start();

				switch ($category) {
					case 'line':
						get_template_part('images/line');
						break;
					case 'facebook':
						get_template_part('images/facebook');
						break;
					case 'instagram':
						get_template_part('images/instagram');
						break;
					case 'google-form':
						echo  esc_html($title) ;
						break;
					default:
						echo '<span>' . esc_html($category) . '</span>';
				}
				
				$icon = ob_get_clean();

				$social_items .= '<li class="menu-item-social menu-item-' . esc_attr($category) . '">';
				$social_items .= '<a href="' . $link_url . '" target="_blank" rel="noopener noreferrer">' . $icon . '</a>';
				$social_items .= '</li>';
				
			}
	
		}

		$social_items .= '</ul>';
		
		$line_id = get_field('line_id', $menu); 
    if ($line_id && isset($line_id['line_qrcode']['url'])) {
        $social_items .= '<div id="line_id"><img src="' . esc_url($line_id['line_qrcode']['url']) . '" alt="' . esc_attr($line_id['line_qrcode']['alt'] ?? '') . '" /></div>';
    }
		$social_items .= '<ul class="contact-info">';

		$address = get_field('address', $menu);
        $phone = get_field('phone', $menu);
        $email = get_field('email', $menu);

		if ($address) {
            $social_items .= '<li class="menu-item-address">地址：' . esc_html($address) . '</li>';
        }

        if ($phone) {
            $social_items .= '<li class="menu-item-phone">電話： ' . esc_html($phone) . '</li>';
        }
		
		if ($line_id && isset($line_id['user_line_id'])) {
			$social_items .= '<li class="menu-item-lineid">Line ID： '. esc_html($line_id['user_line_id'] ?? ''). '</li>';
		}
		
		if ($email) {
			$social_items .= '<li class="menu-item-email">電子郵件： ' . esc_html($email) . '</li>';
		}
		
		$social_items .= '</ul>';

        // Append social icons to existing items
        $items .= $social_items;
    }

    return $items;
}