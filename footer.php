<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jifitness_Theme
 */

?>

	<footer id="colophon" class="site-footer bg-black">

		<div class="footer-menus flex flex-col justify-between p-4 pb-0 [@media(min-width:37.5rem)]:grid [@media(min-width:37.5rem)]:grid-cols-2 
            [@media(min-width:58rem)]:flex [@media(min-width:58rem)]:flex-row [@media(min-width:58rem)]:flex-wrap [@media(min-width:58rem)]:justify-around">
			<nav class="footer-logo">
				<?php
				if ( function_exists( 'the_custom_logo' ) ) {
					the_custom_logo();
				}

				// get tag line
				$jifitness_description = get_bloginfo( 'description', 'display' );
				if ( $jifitness_description || is_customize_preview() ) :?>
	
				<p class="site-description text-white p-2"><?php echo $jifitness_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif;
				?>
			</nav>

			<nav class="footer-social-media">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-social-media'
					)
				);
				?>
			</nav>

			<nav class="footer-sitemap">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-sitemap'
					)
				);
				?>
			</nav>
		</div><!-- .footer-menus -->

		<hr class="mt-4 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
		
		<div class="site-info pb-6 text-center">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'jifitness' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'jifitness' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'jifitness' ), 'jifitness', '<a href="https://jifitness-studio.com/">Jean, Marie</a>' );
				?>
			<?php wp_footer(); ?>
		</div><!-- .site-info -->

		<div class="floating-btn">
			<?php get_template_part( 'template-parts/content', 'floating-button' ); ?>
		</div><!-- .floating btn -->
	
	</footer><!-- #colophon -->
</div><!-- #page -->


</body>
</html>
