<?php
/**
 * The template for displaying the about-us page
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

    <?php get_template_part( 'template-parts/content', 'manifesto' ); ?>

    <?php get_template_part( 'template-parts/content', 'contact' ); ?>

    <!-- studio icon -->

    <?php

    // Check rows exists.
    if( have_rows('studio_description') ):

        // Loop through rows.
        while( have_rows('studio_description') ) : the_row();

            // Load sub field value.
            $icon = get_sub_field('studio_icon');
            // Do something, but make sure you escape the value if outputting directly...
            
            if ($icon){
                echo '<div class="studio-icon">';
                echo ($icon);
                echo '</div>';
            } 
        // End loop.
        endwhile;

    // No value.
    else :
        // Do something...
    endif;
    
    ?>
            

    </main>

<?php
get_footer();