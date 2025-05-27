<?php
/**
 * Partial template for the manifesto section on the About Us page
 *
 * @package Jifitness_Theme
 */

if ( ! function_exists( 'get_field' ) ) {
    return;
}


$page_id = get_query_var('manifesto_page_id', get_the_ID());

$heading   = get_field( 'manifesto_heading', $page_id );
$quotation = get_field( 'manifesto_quotation', $page_id );
$text      = get_field( 'manifesto_text' , $page_id);
$images    = get_field( 'manifesto_images' , $page_id);

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
                    <img src="<?php echo esc_url( $image['sizes']['large'] ); ?>"
                         alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( $text ) : ?>
        <p><?php echo wp_kses_post( $text ); ?></p>
    <?php endif; ?>
</section>
