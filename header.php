<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jifitness_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'jifitness' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<!-- header logo -->
			<a class="header-custom-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
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
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<svg aria-label="Header Menu" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m22 16.75c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75z" fill-rule="nonzero"/></svg>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'header',
					'menu_id'        => 'header-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
