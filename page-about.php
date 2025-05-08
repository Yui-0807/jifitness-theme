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


    <h2>在code裡我們的理念Manifesto</h2>
    <section>
    <?php
    if ( function_exists( 'get_field' ) ) {

        if ( get_field( 'title' ) ) {
            echo '<h3>';
            the_field( 'title' );
            echo '</h3>';
        }

        $images = get_field('manifesto_images');
        if( $images ):
            echo '<div class="acf-gallery">';
            foreach( $images as $image ):
                echo '<div class="gallery-item">';
                echo '<img src="' . esc_url($image['sizes']['medium']) . '" alt="' . esc_attr($image['alt']) . '" />';
                echo '</div>';
            endforeach;
            echo '</div>';
        endif;
        
        if ( get_field( 'manifesto_content' ) ) {
            echo '<p>';
            the_field( 'manifesto_content' );
            echo '</p>';
        }

    }
    ?>
    </section>



</main>



    <main id="primary" class="site-main">

            

    </main>

<?php
get_footer();