<section class="banner">
  <?php if (function_exists('get_field')) :
    $page_id = get_query_var('banner_page_id', get_the_ID());
    if (have_rows('page_banner', $page_id)) :
  ?>
    <div class="swiper banner-swiper">
      <div class="swiper-wrapper">
        <?php while (have_rows('page_banner', $page_id)) : the_row();
          $heading = get_sub_field('heading');
          $description = get_sub_field('description');
          $view_all = get_sub_field('view_all');
          $image = get_sub_field('image');
        ?>
          <div class="swiper-slide banner-content">
            <div class="content-background">
              <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
              <?php endif; ?>
              <?php if ($description) : ?>
                <p><?php echo esc_html($description); ?></p>
              <?php endif; ?>
              <?php if ($view_all && is_array($view_all) && isset($view_all['url'])) : ?>
                <a href="<?php echo esc_url($view_all['url']); ?>">View All</a>
              <?php endif; ?>
            </div>
            <?php if ($image) :
              echo wp_get_attachment_image($image['id'], 'full', false, array('alt' => esc_attr($image['alt'])));
            endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  <?php endif; endif; ?>
</section>
