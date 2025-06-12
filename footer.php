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
			<div class="footer-logo">
				
				<a class="footer-custom-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php get_template_part('images/logo'); ?>
				</a>
				<?php 
				if ( function_exists( 'get_field' ) ) :
					$menu = wp_get_nav_menu_object('footer-logo');

					// 先取得 ACF 欄位
					$manderin_slogon = get_field( 'mandarin_tagline',$menu );
					$eng_slogon  = get_field( 'english_tagline' ,$menu);

					// 正常輸出
					if ( $manderin_slogon ) {
						echo '<ul class="site-description"><li>' . esc_html( $manderin_slogon ) . '</li>';
					}

					if ( $eng_slogon ) {
						echo '<li>' . esc_html( $eng_slogon ) . '</li></ul>';
					}

				endif;
				?>
			</div>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-social-media',
				)
			);
			wp_nav_menu(
				array(
					'theme_location' => 'footer-sitemap'
				)
			);
			?>

			<div class="footer-certificate">
				<?php

				$certificates  = get_field( 'certificate_logo' ,$menu);

				if( $certificates ): ?>
					<ul>
						<?php foreach( $certificates as $certificate ): ?>
							<li>
								<img src="<?php echo $certificate['sizes']['thumbnail']; ?>" alt="<?php echo $certificate['alt']; ?>" />
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div><!-- .footer-menus -->

		<hr />
		
		<div class="site-info">
			<p>©2025 Jifitness_Theme</p>
			<?php wp_footer(); ?>
		</div><!-- .site-info -->

		<div class="floating-btn">
			<?php get_template_part( 'template-parts/content', 'floating-button' ); ?>
		</div><!-- .floating btn -->
	
	</footer><!-- #colophon -->
</div><!-- #page -->


</body>
</html>
