<section class="banner">
  <?php if ( function_exists( 'get_field' ) ) : 
    $page_id = get_query_var( 'banner_page_id', get_the_ID() );
    $is_homepage = is_front_page();

    if ( have_rows( 'page_banner', $page_id ) ) :
  ?>
    <div class="swiper banner-swiper">
      <div class="swiper-wrapper">
        <?php while ( have_rows( 'page_banner', $page_id ) ) : the_row(); 
          $heading     = get_sub_field( 'heading' );
          $description = get_sub_field( 'description' );
          $view_all    = get_sub_field( 'view_all' );
          $image       = get_sub_field( 'image' );
        ?>
          <article class="swiper-slide banner-content <?php echo $is_homepage ? 'is-front-page' : 'is-inner-page'; ?>">

            <div class="content-background">
              <?php if ( $heading ) : ?>
                <h1><?php echo esc_html( $heading ); ?></h1>
              <?php endif; ?>

              <?php if ( $description ) : ?>
                <?php if ( $is_homepage ) : ?>
                  <?php $points = explode( '｜', $description ); ?>
                  <ul class="banner-list">
                    <?php foreach ( $points as $point ) : ?>
                      <li><?php echo esc_html( trim( $point ) ); ?></li>
                    <?php endforeach; ?>
                  </ul>

                <?php else : ?>
                  <p class="banner-paragraph"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

              <?php endif; ?>

              <?php
                if ( $view_all && is_array( $view_all ) && isset( $view_all['url'] ) ) :
                  $button_label = isset( $view_all['title'] ) && $view_all['title'] ? $view_all['title'] : 'View All';
              ?>
                <a href="<?php echo esc_url( $view_all['url'] ); ?>">
                  <?php echo esc_html( $button_label ); ?>
                </a>
              <?php endif; ?>

            </div>

              <?php 
                if ( $image ) {
                  echo wp_get_attachment_image( 
                    $image['id'], 
                    'full', 
                    false, 
                    [ 'alt' => esc_attr( $image['alt'] ) ] 
                  );
                }
              ?>
          </article>

        <?php endwhile; ?>
      </div>

      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    <div class="banner-bottom"></div>


  <?php endif; endif; ?>

    <?php if ( is_front_page() ) : ?>
      <div class="scroll-indicator" aria-hidden="true">
        <span>↓</span>
      </div>
    <?php endif; ?>

    <?php if ( ! is_front_page() ) : ?>
      <img class="pages-banner-deco" src="<?php echo get_template_directory_uri(); ?>/images/banner-deco.webp" alt="banner-deco" loading="lazy">
    <?php endif; ?>
  
</section>
