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

    <?php
        $core_values = get_field('core_value_group');
        if ($core_values) :
        ?>
        <section class="core-values-section">
            <div class="container">
                <h2 class="core-value-heading"><?php echo esc_html( get_field('core_value_heading') ); ?></h2>

                <div class="core-values-grid">
                    <?php for ($i = 1; $i <= 3; $i++) :
                        $group_key = 'core_value_' . $i;
                        if (!isset($core_values[$group_key])) continue;
                        $value = $core_values[$group_key];
                        $bg_image = $value[$group_key . '_image'];
                        $icon     = $value[$group_key . '_icon'];
                        $title    = $value[$group_key . '_title'];
                        $text     = $value[$group_key . '_text'];
                    ?>
                        <div class="core-value-item" style="background-image: url('<?php echo esc_url($bg_image['url']); ?>')">
                            <?php if ($icon) : ?>
                                <img class="core-value-icon" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" />
                            <?php endif; ?>
                            <h3 class="core-value-title"><?php echo esc_html($title); ?></h3>
                            <p class="core-value-text"><?php echo esc_html($text); ?></p>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

    <?php get_template_part( 'template-parts/content', 'team' ); ?>
   
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