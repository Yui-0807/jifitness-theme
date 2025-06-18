<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>
<div class="cotent-container">
	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();?>

				<article 
				id="post-<?php the_ID(); ?>" 
				<?php post_class(); ?>
				data-aos="fade-up"
          		data-aos-duration="1500">

					<a href="<?php the_permalink(); ?>">
						<div class="entry-header">
							<?php the_post_thumbnail( 'landscape-blog' ); ?>
						</div><!-- .entry-header -->

						<div class="entry-content">
							<p class="date"><?php echo get_the_date(); ?> </p>
							<h2><?php the_title(); ?></h2>
							
							<hr />
							<?php the_excerpt(); ?>

							<button class="read-post-link default-btn">繼續閱讀
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

	</main><!-- #main -->

<?php
get_sidebar();

echo "</div>";
get_footer();
