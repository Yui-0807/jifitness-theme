<?php
/**
 * The template for displaying the about-us page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Jifitness_Theme
 */

get_header();
?>

<?php get_template_part( 'template-parts/content', 'banner' ); ?>

<main id="primary" class="site-main">

    <?php get_template_part( 'template-parts/content', 'manifesto' ); ?>

    <?php
    $core_values = get_field('core_value_group');
    if ( $core_values ) :
    ?>
        <section class="core-values-section">
            <div class="container">
                <h2 class="core-value-heading">核心理念<span>Core Value</span></h2>

                <div class="core-values-grid">
                    <?php for ( $i = 1; $i <= 3; $i++ ) :
                        $group_key = 'core_value_' . $i;
                        if ( ! isset( $core_values[ $group_key ] ) ) continue;

                        $value    = $core_values[ $group_key ];
                        $bg_image = $value[ $group_key . '_image' ];
                        $icon     = $value[ $group_key . '_icon' ];
                        $title    = $value[ $group_key . '_title' ];
                        $text     = $value[ $group_key . '_text' ];
                    ?>
                        <article class="core-value-item" style="background-image: url('<?php echo esc_url( $bg_image['url'] ); ?>')">
                            <?php if ( $icon ) : ?>
                                <img class="core-value-icon" src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" />
                            <?php endif; ?>
                            <h3 class="core-value-title"><?php echo esc_html( $title ); ?></h3>
                            <p class="core-value-text"><?php echo esc_html( $text ); ?></p>
                        </article>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php get_template_part( 'template-parts/content', 'team' ); ?>
    <?php get_template_part( 'template-parts/content', 'studio-environment' ); ?>
    <?php get_template_part( 'template-parts/content', 'facility' ); ?>

        <h2 class="studio-rates-heading">健身房租借收費方式<span>Studio Rental Rates</span></h2>
        <?php get_template_part( 'template-parts/content', 'rental-pricing' ); ?>
        
    <?php get_template_part( 'template-parts/content', 'contact' ); ?>
    <?php get_template_part( 'template-parts/content', 'joinus' ); ?>


</main>

<?php get_footer(); ?>
