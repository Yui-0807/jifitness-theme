<?php
/**
 * The template for displaying the class-recommendation page
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



    
</main>