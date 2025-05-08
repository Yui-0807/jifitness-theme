<?php
/**
 * Partial template for the manifesto section on the About Us page
 *
 * @package Jifitness_Theme
 */

if ( ! function_exists( 'get_field' ) ) {
    return;
}

$heading   = get_field( 'manifesto_heading' );
$quotation = get_field( 'manifesto_quotation' );
$text      = get_field( 'manifesto_text' );
$images    = get_field( 'manifesto_images' );

?>

<section class="manifesto-section">
    <?php if ( $heading ) : ?>
        <h3><?php echo esc_html( $heading ); ?></h3>
    <?php endif; ?>

    <?php if ( $quotation ) : ?>
        <h3><?php echo esc_html( $quotation ); ?></h3>
    <?php endif; ?>

    <?php if ( $images ) : ?>
        <div class="acf-gallery">
            <?php foreach ( $images as $image ) : ?>
                <figure class="gallery-item">
                    <img src="<?php echo esc_url( $image['sizes']['medium'] ); ?>"
                         alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                    <?php if ( ! empty( $image['caption'] ) ) : ?>
                        <figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( $text ) : ?>
        <p><?php echo wp_kses_post( $text ); ?></p>
    <?php endif; ?>
</section>
