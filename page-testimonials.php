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

<div class="modals">
<!-- Modal toggle -->
<?php
$args = array(
    'post_type'      => 'ji-testimonials',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'ji-featured',
            'field'    => 'slug',
            'terms'    => 'featured', 
        ),
    ),
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while( $query->have_posts() ) {
        $query->the_post(); ?>

        <!-- Modal -->
        <?php get_template_part( 'template-parts/content', 'testimonials-card' ); ?>

    <?php            
    }
    wp_reset_postdata();
} 
?>

<?php
// 非 featured 的 testimonials
$non_featured_args = array(
    'post_type'      => 'ji-testimonials',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'ji-featured',
            'field'    => 'slug',
            'terms'    => 'featured',
            'operator' => 'NOT IN', // 排除 featured
        ),
    ),
);
$non_featured_query = new WP_Query( $non_featured_args );

if ( $non_featured_query->have_posts() ) {
    while ( $non_featured_query->have_posts() ) {
        $non_featured_query->the_post(); ?>

        <!-- Modal -->
        <?php get_template_part( 'template-parts/content', 'testimonials-card' ); ?>

    <?php
    }
    wp_reset_postdata();
}
?>

</div>
</div>
</main>
<?php
get_footer();