
<section class="banner">
  <?php if (function_exists('get_field')) : 
        $page_id = get_query_var('banner_page_id'); // get the id
        $banner_data = get_field('page_banner', $page_id); // use the id of page

    while (have_rows('page_banner', $page_id)) : the_row();
        $heading = get_sub_field('heading');
        $description = get_sub_field('description');
        $view_all = get_sub_field('view_all');
        $image = get_sub_field('image');
    ?>
        <div class="banner-content">
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
                $image_id = $image['id']; 
                echo wp_get_attachment_image($image_id, 'full', false, array('alt' => esc_attr($image['alt'])));
            endif; ?>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>
</section>
