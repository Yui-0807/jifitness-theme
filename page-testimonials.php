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

<main id="primary" class="site-main">

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content', 'banner' ); ?>
    <?php endwhile; ?>
<?php else : ?>
    <p>目前沒有內容。</p>
<?php endif; ?>


<!-- Modal toggle -->
<?php
$args = array(
    'post_type'      => 'ji-testimonials',
    'posts_per_page' => -1,
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while( $query->have_posts() ) {
        $query->the_post(); 
        $modal_id = 'testimonial-modal-' . get_the_ID(); // 唯一 Modal ID
        
         // 设置模板需要的变量
         $template_args = array(
            'modal_id' => $modal_id,
            'post_title' => get_the_title(),
            'post_content' => get_the_content(),
            'post_thumbnail' => get_the_post_thumbnail(null, 'medium')
        );
        get_template_part( 'template-parts/content', 'modal', $template_args );
        
    }
    wp_reset_postdata();
} 
?>



</main>
<?php
get_footer();