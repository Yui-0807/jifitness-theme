<?php
/**
 * The template for displaying the small-group page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Jifitness_Theme
 */

get_header();
?>

<?php get_template_part( 'template-parts/content', 'banner' ); ?>

<main id="primary" class="site-main page-small-group">

  <!-- Intro 區塊 -->
  <section>
    <?php
    if ( function_exists( 'get_field' ) ) :
      $intro_title = get_field( 'intro_title' );
      $intro_text  = get_field( 'intro_text' );

      if ( $intro_title ) {
        echo '<h2>' . esc_html( $intro_title ) . '</h2>';
      }

      if ( $intro_text ) {
        echo '<div class="intro-text">' . wp_kses_post( $intro_text ) . '</div>';
      }
    endif;
    ?>
  </section>

  <section>
    <?php
    $args = array(
      'post_type'      => 'ji-small-group',
      'posts_per_page' => -1,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) :
      while ( $query->have_posts() ) :
        $query->the_post();
        $post_id = get_the_ID();
        $image   = get_field( 'class_image' );

        $class = ( $query->current_post % 2 === 1 ) ? 'small-group-item reverse' : 'small-group-item';
        ?>
        <div 
          class="<?php echo esc_attr( $class ); ?>" 
          id="small-group-<?php echo esc_attr( $post_id ); ?>"
          data-aos="fade-up"
          data-aos-duration="1500">

          <?php if ( $image ) : ?>
            <div class="image-wrapper">
              <img 
                src="<?php echo esc_url( $image['url'] ); ?>" 
                alt="<?php echo esc_attr( $image['alt'] ); ?>" 
              />
            </div>
          <?php endif; ?>

          <div class="text-block">
            <h3><?php the_title(); ?></h3>

            <?php if ( get_field( 'class_description' ) ) : ?>
              <div class="class-description">
                <?php echo wp_kses_post( get_field( 'class_description' ) ); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </section>

  <section class="mood-wrapper">
    <?php get_template_part('template-parts/content', 'mood'); ?>
  </section>

  <h2 class="training-rates-heading">課程收費方式<span>Invest in Your Training</span></h2>
    <div class="small-group-table">
        <?php get_template_part( 'template-parts/content', 'rental-pricing' ); ?>
    </div>

</main>

<?php get_footer(); ?>
