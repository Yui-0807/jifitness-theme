<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jifitness_Theme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php
		$sticky = get_option( 'sticky_posts' );

		if ( ! empty( $sticky ) ) {
			$sticky_query = new WP_Query( array(
				'post__in'            => $sticky,
				'orderby'             => 'post__in',  // 按照 ID 陣列順序排序
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => 3,
			) );

			if ( $sticky_query->have_posts() ) :
				?>
				<section class="widget widget_sticky_posts">
					<h3 class="widget-title">精選文章</h3>
					<ul>
						<?php while ( $sticky_query->have_posts() ) : $sticky_query->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'thumbnail' );
									} ?>
									<h4><?php the_title(); ?></h4>
									<span><?php echo get_the_date(); ?></span>
									<?php the_excerpt(); ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</section>
				<?php
				wp_reset_postdata();
			endif;
		}
	?>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
