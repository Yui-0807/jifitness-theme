<?php
/**
 * The template for displaying the testimonials page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>

<?php get_template_part( 'template-parts/content', 'banner' ); ?>

<main id="primary" class="site-main">


<!-- Modal toggle -->
<?php
$args = array(
    'post_type'      => 'ji-testimonials',
    'posts_per_page' => -1,
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while( $query->have_posts() ) {
        $query->the_post(); ?>

        <div class="testimonial-card">
        <div class="testimonial-card_inner">
            <div class="testimonial-text">
                <h2><?php the_title(); ?></h2>

                <div class="testimonial-card_hashtag">
                    <?php if( have_rows('testimoniales_hashtag') ): while( have_rows('testimoniales_hashtag') ) : the_row();
                        $hashtag = get_sub_field('hashtag');
                        if( $hashtag ):
                            $link_url = $hashtag['url'];
                            $link_title = $hashtag['title']; ?>
                            <a class="hashtag" href="<?php echo esc_url( $link_url ); ?>">
                                <?php echo esc_html( $link_title ); ?>
                            </a>
                        <?php endif;
                    endwhile; endif;?>
                </div>
                <p><?php the_content(); ?></p>
            </div>

            <div class="testimonial-image">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
            </div>
        </div>
        </div>

    <?php            
    }
    wp_reset_postdata();
} 
?>
</main>
<?php
get_footer();