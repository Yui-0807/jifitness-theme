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
        $query->the_post(); ?>

        <div class="default-card testimonial-card">
            <!-- Model btn -->
            <label for="modal-<?php echo get_the_ID(); ?>" >
            <?php if (has_post_thumbnail()) : ?>
                <div class="testimonial-card__image">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
                </div>
            <?php endif; ?>
            <div class="testimonial-card__content">
                <h2><?php the_title(); ?></h2>

                <div class="testimonial-card_hashtag">
                <!-- output haastag -->
                <?php
                // Check rows exists.
                if( have_rows('testimoniales_hashtag') ):

                    // Loop through rows.
                    while( have_rows('testimoniales_hashtag') ) : the_row();

                        // Load sub field value.
                        $hashtag = get_sub_field('hashtag');
                        if( $hashtag ): 
                            $link_url = $hashtag['url'];
                            $link_title = $hashtag['title'];?>
                            <a 
                            class="hashtag" 
                            href="<?php echo esc_url( $link_url ); ?>
                            ">
                                <?php echo esc_html( $link_title ); ?>
                            </a>
                        <?php endif;

                    // End loop.
                    endwhile;
                endif;?>
                </div>
                <?php the_excerpt(); ?>
            </div>
            </label>
        </div>

        <!-- Modal content -->
        <input type="checkbox" id="modal-<?php echo get_the_ID(); ?>" class="modal-state">
        <div class="modal">
            <label for="modal-<?php echo get_the_ID(); ?>" class="modal__bg"></label>
            <div class="modal__inner">
                <label class="modal__close" for="modal-<?php echo get_the_ID(); ?>"></label>
                <?php the_post_thumbnail('large'); ?>
                
                <div class="modal__content">
                    <h2><?php the_title(); ?></h2>
                    <div class="modal__hashtag">
                    <!-- output haastag -->
                        <?php
                        // Check rows exists.
                        if( have_rows('testimoniales_hashtag') ):

                            // Loop through rows.
                            while( have_rows('testimoniales_hashtag') ) : the_row();

                                // Load sub field value.
                                $hashtag = get_sub_field('hashtag');
                                if( $hashtag ): 
                                    $link_url = $hashtag['url'];
                                    $link_title = $hashtag['title'];?>
                                    <a 
                                    class="hashtag" 
                                    href="<?php echo esc_url( $link_url ); ?>
                                    ">
                                        <?php echo esc_html( $link_title ); ?>
                                    </a>
                                <?php endif;

                            // End loop.
                            endwhile;
                        endif;?>
                    </div>
                    <?php the_content(); ?>
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