<?php
/**
 * Partial template for the manifesto section on the About Us page
 *
 * @package Jifitness_Theme
 */

if ( ! function_exists( 'get_field' ) ) {
    return;
}

$page_id   = get_query_var('manifesto_page_id', get_the_ID());
$quotation = get_field( 'manifesto_quotation', $page_id );
$text      = get_field( 'manifesto_text', $page_id );
$images    = get_field( 'manifesto_images', $page_id );
?>

<section class="manifesto-section" id="manifesto">

    <h2 class="manifesto-heading">我們的理念<span>Manifesto</span></h2>

   <!-- Blob Clip SVG 定義（使用比例座標）-->
    <svg width="0" height="0" style="position: absolute;">
    <defs>
        <clipPath id="blob-2" clipPathUnits="objectBoundingBox">
        <path transform="scale(1, 0.85) translate(0, 0.075)"
        d="M0.048 0.445C0.12 0.319 0.209 0.2 0.324 0.113C0.381 0.07 0.444 0.034 0.512 0.014C0.579 -0.007 0.656 -0.005 0.717 0.034C0.77 0.067 0.817 0.111 0.855 0.163C0.913 0.244 0.954 0.338 0.979 0.437C0.998 0.519 1.012 0.608 0.992 0.69C0.984 0.72 0.973 0.749 0.955 0.774C0.912 0.829 0.853 0.865 0.795 0.899C0.694 0.958 0.586 1 0.474 1.011C0.387 1.025 0.293 1.032 0.21 1.005C0.103 0.965 0.018 0.858 0.004 0.737C0 0.702 0.0002 0.667 0.003 0.632C0.009 0.571 0.025 0.51 0.048 0.445Z"/>
        </clipPath>
    </defs>
    </svg>

    <svg width="0" height="0" viewBox="0 0 1 1" xmlns="http://www.w3.org/2000/svg">
    <defs>    
        <clipPath id="blob-3" clipPathUnits="objectBoundingBox">
            <path transform="scale(1, 0.85) translate(0, 0.075)"
            d="M0.1125 0.6908C0.2113 0.7992 0.3248 0.8948 0.455 0.95C0.5195 0.9775 0.588 0.9969 0.6573 0.9982C0.726 0.9995 0.7979 0.9759 0.8473 0.9205C0.89 0.8727 0.9235 0.8154 0.9469 0.7533C0.9834 0.657 0.9994 0.552 1 0.448C1 0.3615 0.9921 0.2709 0.953 0.1947C0.9389 0.1667 0.9213 0.1399 0.8975 0.1208C0.8428 0.0769 0.7768 0.0574 0.713 0.0384C0.6045 0.0063 0.491 -0.0081 0.3792 0.0046C0.293 0.0144 0.2015 0.0306 0.1319 0.0887C0.0416 0.164 0.0132 0.2946 0.0027 0.4202C0.0073 0.4562 0.016 0.4916 0.0274 0.5255C0.0477 0.5853 0.0775 0.6403 0.1125 0.6908Z"/>
        </clipPath>
    </defs>
    </svg>

    <svg width="0" height="0" viewBox="0 0 1 1" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <clipPath id="blob-4" clipPathUnits="objectBoundingBox">
            <path transform="scale(1, 0.85) translate(0, 0.075)"
            d="M0.8875 0.6908C0.7887 0.7992 0.6752 0.8948 0.545 0.95C0.4805 0.9775 0.412 0.9969 0.3427 0.9982C0.274 0.9995 0.2021 0.9759 0.1527 0.9205C0.11 0.8727 0.0765 0.8154 0.0531 0.7533C0.0166 0.657 0.0006 0.552 0 0.448C0 0.3615 0.0079 0.2709 0.047 0.1947C0.0611 0.1667 0.0787 0.1399 0.1025 0.1208C0.1572 0.0769 0.2232 0.0574 0.287 0.0384C0.3955 0.0063 0.509 -0.0081 0.6208 0.0046C0.707 0.0144 0.7985 0.0306 0.8681 0.0887C0.9584 0.164 0.9868 0.2946 0.9973 0.4202C0.9927 0.4562 0.984 0.4916 0.9726 0.5255C0.9523 0.5853 0.9225 0.6403 0.8875 0.6908Z"/>
        </clipPath>
    </defs>
    </svg>

    <?php if ( $images ) : ?>
        <div class="acf-gallery">
            <?php 
            $index = 1;
            foreach ( $images as $image ) : ?>
                <figure class="gallery-item blob-<?php echo $index; ?>">
                    <img src="<?php echo esc_url( $image['sizes']['large'] ); ?>"
                         alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                </figure>
                <?php $index++; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( $quotation ) : ?>
        <h3><?php echo nl2br( esc_html( $quotation ) ); ?></h3>
    <?php endif; ?>

    <?php if ( $text ) : ?>
        <div class="manifesto-text">
            <p><?php echo wp_kses_post( $text ); ?></p>
        </div>
    <?php endif; ?>

    <button class="default-btn manifesto-btn">更多關於 JI Fitness</button>
</section>
