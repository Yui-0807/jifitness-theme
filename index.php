<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();

// <!-- index.php - Banner -->

$banner_page_id = 33; // id of index.php
set_query_var('banner_page_id', $banner_page_id); // sent var
get_template_part('template-parts/content', 'banner'); // loaded into template
?>

<div class="blog-cotent-container">
	<main id="primary" class="site-main">
	<div class="container">
		
		<?php if ( is_home() && ! is_front_page() ) :?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>


		<?php			
			/* Start the Loop */
			if ( have_posts() ) :
			while ( have_posts() ) : the_post();?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<a href="<?php the_permalink(); ?>">
						<div class="entry-header">
							<?php the_post_thumbnail( 'landscape-blog' ); ?>
						</div><!-- .entry-header -->

						<div class="entry-content">
							<p class="date"><?php echo get_the_date(); ?> </p>
							<h2><?php the_title(); ?></h2>
							
							<hr />
							<?php the_excerpt(); ?>

							<button class="read-post-link">繼續閱讀
								<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
							</button>
						</div><!-- .entry-content -->	

					</a>
				</article><!-- #post-<?php the_ID(); ?> -->
			<?php endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</div>
	</main><!-- #main -->

<?php
get_sidebar();
echo'</div>';
get_footer();
