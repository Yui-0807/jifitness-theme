<?php
/**
 * Partial template for the Contact section
 *
 * @package Jifitness_Theme
 */

$menu = wp_get_nav_menu_object('footer-social-media');

$address = get_field('address', $menu);
$phone = get_field('phone', $menu);
$email = get_field('email', $menu);
$line_id = get_field('line_id', $menu);
$contact_image = get_field('contact_image'); 
?>

<section class="contact-section" id="contact">

    <h2 class="contact-heading">聯絡我們<span>Contact Info</span></h2>

    <div class="contact-wrapper">

    <div class="contact-left">
      <ul class="contact-list">

        <?php if ($phone): ?>
          <li class="contact-item">
            <div class="icon"><?php get_template_part('images/phone'); ?></div>
            <div class="info">
              <span>聯絡電話 Phone</span>
              <p><?php echo esc_html($phone); ?></p>
            </div>
          </li>
        <?php endif; ?>

        <?php if ($email): ?>
          <li class="contact-item">
            <div class="icon"><?php get_template_part('images/email'); ?></div>
            <div class="info">
              <span>聯絡信箱 Mail</span>
              <p><?php echo esc_html($email); ?></p>
            </div>
          </li>
        <?php endif; ?>

        <?php if ($address): ?>
          <li class="contact-item">
            <div class="icon"><?php get_template_part('images/map'); ?></div>
            <div class="info">
              <span>場館位置 Address</span>
              <p><?php echo nl2br(esc_html($address)); ?></p>
            </div>
          </li>
        <?php endif; ?>

        <?php if ($line_id && isset($line_id['line_qrcode']['url'])): ?>
          <li class="contact-item">
            <div class="icon"><?php get_template_part('images/line'); ?></div>
            <div class="info">
              <span>官方Line ID</span>
              <p><?php echo esc_html($line_id['user_line_id'] ?? '') ?></p>
              <img class="line-qrcode" src="<?php echo esc_url($line_id['line_qrcode']['url']) ?>" alt="<?php echo esc_attr($line_id['line_qrcode']['alt'] ?? '') ?>" />
            </div>
          </li>
        <?php endif; ?>

        <?php
        $has_facebook = false;
        $has_instagram = false;

        if (have_rows('social_media', $menu)) :
          while (have_rows('social_media', $menu)) : the_row();
            $title = get_sub_field('title');
            $url = get_sub_field('social_media_links');
            $category = get_sub_field('category');

            if ($category === 'facebook' && !$has_facebook):
              $has_facebook = true;
        ?>
              <li class="contact-item">
                <div class="icon"><?php get_template_part('images/facebook'); ?></div>
                <div class="info">
                  <span>Facebook官方粉專</span>
                  <p><a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a></p>
                </div>
              </li>
        <?php
            elseif ($category === 'instagram' && !$has_instagram):
              $has_instagram = true;
        ?>
              <li class="contact-item">
                <div class="icon"><?php get_template_part('images/instagram'); ?></div>
                <div class="info">
                  <span>Instagram官方帳號</span>
                  <p><a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($title); ?></a></p>
                </div>
              </li>
        <?php
            endif;
          endwhile;
        endif;
        ?>

      </ul>
    </div>

    <div class="contact-right">
        <div class="contact-image-wrapper">
            <img src="<?php echo esc_url($contact_image['url']); ?>" alt="<?php echo esc_attr($contact_image['alt'] ?? '聯絡我們圖片'); ?>" />
            <div class="contact-slogan">
            <p>HEALTH</p>
            <p>CONFIDENCE</p>
            <p>BEAUTY</p>
            </div>
        </div>
    </div>

  </div>
    

  <div class="contact-map-container">
    <div id="map" style="width: 100%; height: 450px; margin-top: 2rem;"></div>
  </div>
  
</section>


