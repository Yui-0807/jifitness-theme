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

	<footer id="colophon" class="site-footer">

		<div class="footer-menus">
			<nav class="footer-logo">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-logo'
					)
				);
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

		<div class="site-info">
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
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
