<?php
/**
 * The template for displaying the small-group page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content', 'banner' ); ?>
    <?php endwhile; ?>
<?php else : ?>
    <p>目前沒有內容。</p>
<?php endif; ?>


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

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post(); ?>

            <div class="one-on-one-item">
                <h3><?php the_title(); ?></h3>

                <?php if ( get_field('class_description_test') ): ?>
                    <div class="class-description">
                        <?php echo wp_kses_post( get_field('class_description_test') ); ?>
                    </div>
                <?php endif; ?>

                <?php
                $image = get_field('class_image_test');
                if ( $image ): ?>
                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="max-width:300px;" />
                <?php endif; ?>
            </div>

        <?php }
        wp_reset_postdata();
    }
?>
</section>



</main>