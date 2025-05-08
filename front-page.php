<?php
/**
 * The template for displaying the Front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

<h1 class="bg-red-500">Tailwind Works!!</h1>


<section class="banner">
  <?php if ( have_rows( 'page_banner' ) ) : ?>
    <div class="swiper banner-swiper">
      <div class="swiper-wrapper">

        <?php while ( have_rows( 'page_banner' ) ) : the_row(); 
          $heading     = get_sub_field( 'heading' );
          $description = get_sub_field( 'description' );
          $view_all    = get_sub_field( 'view_all' );
          $image       = get_sub_field( 'image' );
        ?>
          <div class="swiper-slide banner-content">
            <div class="content-background">
              <?php if ( $heading ) : ?>
                <h2><?php echo esc_html( $heading ); ?></h2>
              <?php endif; ?>

              <?php if ( $description ) : ?>
                <p><?php echo esc_html( $description ); ?></p>
              <?php endif; ?>

              <?php if ( ! empty( $view_all['url'] ) ) : ?>
                <a href="<?php echo esc_url( $view_all['url'] ); ?>">View All</a>
              <?php endif; ?>
            </div>

            <?php if ( $image ) : ?>
              <?php 
                echo wp_get_attachment_image(
                  $image['ID'], 
                  'full', 
                  false, 
                  array( 
                    'alt'   => esc_attr( $image['alt'] ?? '' ), 
                    'class' => 'banner-image' 
                  ) 
                ); 
              ?>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>

      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  <?php endif; ?>
</section>

</main>


<?php
get_footer();