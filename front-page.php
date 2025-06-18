<?php
/**
 * The template for displaying the Front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

<h1 class="bg-red-500">Tailwind Works!!</h1>

<!-- Carousel Banners -->
<?php get_template_part('template-parts/content', 'banner'); ?>

<!-- manifesto -->
<?php
$about_page = get_page_by_path('about'); // 假設關於頁面的 slug 是 'about'
set_query_var('manifesto_page_id', $about_page->ID);
get_template_part( 'template-parts/content', 'manifesto' );
?>

<!-- Fitness Classes -->
<section>
<h2>課程介紹</h2>
<p>Fitness Classes</p>
<?php
    $args = array(
        'post_type'      => 'ji-1-on-1',
        'posts_per_page' => 3,
        'tax_query' 		=> array(
          array(
            'taxonomy' => 'ji-featured',
            'field' => 'slug',
            'terms' => 'front-page',
          )
          ),
          'order'      =>'ASC'
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post(); 
            $post_id = get_the_ID(); //get the post id to get to certain page section ?>

            <article id="home-post-<?php the_ID(); ?>" <?php post_class();?>>
              <a href="<?php echo esc_url(home_url('/1-on-1#1-on-1-' . $post_id)); ?>">
                  <h3><?php the_title(); ?></h3>
                  <?php if ( get_field('class_description') ): ?>
                    <p class="home-class-description">
                      <?php
                        $class_description = get_field('class_description');
                        if ($class_description) {
                            // remove html tag then trim the text
                            $text_only = strip_tags($class_description);
                            $short_description = wp_trim_words($text_only, 60, '...繼續閱讀');
                            echo '<div class="class-description">' . $short_description . '</div>';
                        }
                      ?>
                    </p>
                  <?php endif; ?>
               </a>

                <?php
                $image = get_field('class_image');
                if ( $image ): ?>
                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="max-width:300px;" />
                <?php endif; ?>
            </article>

        <?php }
        wp_reset_postdata();
    }
?>

</section>

<!-- Mood Section -->
<section class="mood-wrapper">
<?php get_template_part('template-parts/content', 'mood'); ?>
</section>

<!-- Testimonials -->
<section>
<h2>學員推薦</h2>
<p>Get inspired by our members</p>
  <div class="home-modals">
    <?php
        $args = array(
            'post_type'      => 'ji-testimonials',
            'posts_per_page' => 3,
            'tax_query' 		=> array(
              array(
                'taxonomy' => 'ji-featured',
                'field' => 'slug',
                'terms' => 'front-page',
              )
              )
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post(); ?>

            <!-- Model btn -->
            <label for="modal-<?php echo get_the_ID(); ?>" class="testimonial-card">
            <?php if (has_post_thumbnail()) : ?>
                <div class="testimonial-card__image">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
                </div>
            <?php endif; ?>
            <div class="testimonial-card__content">
                <h3><?php the_title(); ?></h3>
                <?php the_excerpt(); ?>
            </div>
            </label>

            <!-- Modal content -->
            <input type="checkbox" id="modal-<?php echo get_the_ID(); ?>" class="modal-state">
            <div class="modal">
            <label for="modal-<?php echo get_the_ID(); ?>" class="modal__bg"></label>
            <div class="modal__inner">
                <label class="modal__close" for="modal-<?php echo get_the_ID(); ?>"></label>
                <div class="modal__content">
                  <?php the_post_thumbnail('large'); ?>
                  <h3><?php the_title(); ?></h3>
                  <?php the_content(); ?>
                </div>
            </div>
            </div>

        <?php            
            }
            wp_reset_postdata();
        }
    ?>

  </div>
</section>

<!-- Blog -->
<section class="home-blog">
<h2>Irene 教練小教室</h2>
<p>Blog for fitness tips</p>

<?php
$sticky = get_option( 'sticky_posts' );
$displayed_ids = array(); // get the sticky_posts ids

// get max:2 && random sticky_posts 
$sticky_args = array(
	'post__in' => $sticky,
	'orderby'  => 'rand',
	'posts_per_page' => 2,
	'ignore_sticky_posts' => 1,
);

$sticky_query = new WP_Query( $sticky_args );

if ( $sticky_query->have_posts() ) :
	while ( $sticky_query->have_posts() ) : $sticky_query->the_post();
		$displayed_ids[] = get_the_ID(); // put the sticky_posts ids in a array
		?>
		<article id="home-post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'landscape-blog' ); ?>
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt(); ?>
				<?php echo get_the_date(); ?>
			</a>
		</article>
		<?php
	endwhile;
	wp_reset_postdata();
endif;

// count how many space left
$remaining = 3 - count( $displayed_ids );
// get the lastest post to fitin 3 tatal posts
if ( $remaining > 0 ) {
	$latest_args = array(
		'post_type' => 'post',
		'posts_per_page' => $remaining,
		'post__not_in' => $displayed_ids,
		'ignore_sticky_posts' => 1,
	);

	$latest_query = new WP_Query( $latest_args );

	if ( $latest_query->have_posts() ) :
		while ( $latest_query->have_posts() ) : $latest_query->the_post();
			?>
			<article id="home-post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'landscape-blog' ); ?>
					<h3><?php the_title(); ?></h3>
					<?php the_excerpt(); ?>
					<?php echo get_the_date(); ?>
				</a>
			</article>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
}
?>
</section>


</main>


<?php
get_footer();