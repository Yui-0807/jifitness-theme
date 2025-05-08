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


<?php
$args = array(
    'post_type'      => 'ji-testimonials',
    'posts_per_page' => -1,
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while( $query->have_posts() ) {
        $query->the_post(); 
        ?>
        <article>
            <a href="<?php the_permalink(); ?>">
                <h2><?php the_title(); ?></h2>
                <?php the_post_thumbnail('large'); ?>
            </a>
            <?php the_excerpt(); ?>
        </article>
        <?php
    }
    wp_reset_postdata();
} 
?>

<?php
get_footer();