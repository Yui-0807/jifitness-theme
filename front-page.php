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


<section class="banner">
    <?php if ( have_rows( 'page_banner' ) ) : ?>
      <div class="swiper banner-swiper">
        <div class="swiper-wrapper">

          <?php while ( have_rows( 'page_banner' ) ) : the_row(); 
            $heading     = get_sub_field( 'heading' );
            $description = get_sub_field( 'description' );
            $view_all    = get_sub_field( 'view_all' );
            $image       = get_sub_field( 'image' );
          ?>
            <div class="swiper-slide banner-content">
              <div class="content-background">
                <?php if ( $heading ) : ?>
                  <h2><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                  <p><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $view_all['url'] ) ) : ?>
                  <a href="<?php echo esc_url( $view_all['url'] ); ?>">View All</a>
                <?php endif; ?>
              </div>

              <?php if ( $image ) : ?>
                <?php 
                  echo wp_get_attachment_image(
                    $image['ID'], 
                    'full', 
                    false, 
                    array( 
                      'alt'   => esc_attr( $image['alt'] ?? '' ), 
                      'class' => 'banner-image' 
                    ) 
                  ); 
                ?>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>

        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    <?php endif; ?>
  </section>

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

            <article class="home-one-on-one-item">
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

<!-- Testimonials -->
<section>
<h2>學員推薦</h2>
<p>Get inspired by our members</p>

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
            $query->the_post(); 
            $modal_id = 'testimonial-modal-' . get_the_ID(); // 唯一 Modal ID
        
        // 设置模板需要的变量
        $template_args = array(
           'modal_id' => $modal_id,
           'post_title' => get_the_title(),
           'post_content' => get_the_content(),
           'post_thumbnail' => get_the_post_thumbnail(null, 'medium')
       );
       get_template_part( 'template-parts/content', 'modal', $template_args );
       
        }
        wp_reset_postdata();
    }
?>


</section>

<!-- Blog -->
<section class="home-blog">
<h2>Irene 教練小教室</h2>
<p>Blog for fitness tips</p>

			<?php $args = array(
				'post_type' 	 => 'post',
				'posts_per_page' => 3
			); 
			
			$blog_query = new WP_Query( $args );
			if ($blog_query -> have_posts() ){
				while( $blog_query -> have_posts() ){
					$blog_query -> the_post();
					?>
					<article>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'landscape-blog' ); ?>
							<h3><?php the_title(); ?></h3>
              <?php the_excerpt(); ?>
							<!-- Output the Published Date -->
							<?php echo get_the_date(); ?>
						</a>
					</article>
					<?php
				}
				wp_reset_postdata();
			}
			?>

</section>


</main>


<?php
get_footer();