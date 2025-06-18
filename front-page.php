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
<div class="cotent-container">
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
$class_groups = ['home_page_class_info_1', 'home_page_class_info_2', 'home_page_class_info_3'];

foreach( $class_groups as $group_name ):
  if( have_rows($group_name) ):
    while( have_rows($group_name) ): the_row();

      $one_on_one = get_sub_field('1_on_1_class_description');
      $small_group = get_sub_field('small_group_link');

      // 一對一課程
      if( $one_on_one instanceof WP_Post ):
        setup_postdata($one_on_one);
        $image = get_field('class_image', $one_on_one->ID);
        $desc = get_field('class_description', $one_on_one->ID);
        ?>
        <article id="home-post-<?php echo $one_on_one->ID; ?>" <?php post_class('', $one_on_one->ID); ?>>
          <?php if ( $image ): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <?php endif; ?>
          <h3><?php echo get_the_title($one_on_one); ?></h3>
          <?php if ($desc): ?>
            <p class="home-class-description">
              <div class="class-description">
                <?php echo wp_trim_words(strip_tags($desc), 60, '...'); ?>
              </div>
            </p>
          <?php endif; ?>
          <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1#1-on-1-' . $one_on_one->ID)); ?>">
            一對一課程
          </a>
          <?php wp_reset_postdata(); ?>
          <?php endif; ?>
          
          <!-- 團體課程按鈕 -->
          <?php if( $small_group instanceof WP_Post ): ?>
            <?php setup_postdata($small_group); ?>
            <a class="default-btn" href="<?php echo esc_url(home_url('/small-group#small-group-' . $small_group->ID)); ?>">
              團體課程
            </a>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </article>
    <?php endwhile; ?>
  <?php endif;
endforeach;
?>

<a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1')); ?>">了解更多課程</a>
<a class="default-btn" href="<?php echo esc_url(home_url('/class-recommendation')); ?>">找尋適合我的課程</a>
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
    $testimonials = get_field('home_page_testimonials'); // ACF relationship

    if ( $testimonials ):
      foreach ( $testimonials as $post ):
        setup_postdata($post);
        $post_id = get_the_ID(); ?>

        <!-- Modal Button -->
        <label for="modal-<?php echo $post_id; ?>" class="testimonial-card">
          <?php if (has_post_thumbnail()): ?>
            <div class="testimonial-card__image">
              <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
            </div>
          <?php endif; ?>
          <div class="testimonial-card__content">
            <h3><?php the_title(); ?></h3>

            <?php if( have_rows('testimoniales_hashtag') ):
              while( have_rows('testimoniales_hashtag') ) : the_row();
                $hashtag = get_sub_field('hashtag');
                if( $hashtag ): ?>
                  <a class="hashtag" href="<?php echo esc_url($hashtag['url']); ?>">
                    <?php echo esc_html($hashtag['title']); ?>
                  </a>
                <?php endif;
              endwhile;
            endif; ?>

            <?php the_excerpt(); ?>
          </div>
        </label>

        <!-- Modal Content -->
        <input type="checkbox" id="modal-<?php echo $post_id; ?>" class="modal-state">
        <div class="modal">
          <label for="modal-<?php echo $post_id; ?>" class="modal__bg"></label>
          <div class="modal__inner">
            <label class="modal__close" for="modal-<?php echo $post_id; ?>"></label>
            <div class="modal__content">
              <?php the_post_thumbnail('large'); ?>
              <h3><?php the_title(); ?></h3>

              <?php if( have_rows('testimoniales_hashtag') ):
                while( have_rows('testimoniales_hashtag') ) : the_row();
                  $hashtag = get_sub_field('hashtag');
                  if( $hashtag ): ?>
                    <a class="hashtag" href="<?php echo esc_url($hashtag['url']); ?>">
                      <?php echo esc_html($hashtag['title']); ?>
                    </a>
                  <?php endif;
                endwhile;
              endif; ?>

              <?php the_content(); ?>
            </div>
          </div>
        </div>
    <?php
      endforeach;
      wp_reset_postdata();?>
    <?php endif; ?>
  </div>
  <a class="default-btn" href="<?php echo esc_url(home_url('/testimonials')); ?>">
  更多關於 JI Fitness 學員推薦
  </a>
</section>


<!-- Blog -->
<section class="home-blog">
  <h2>Irene 教練小教室</h2>
  <p>Blog for fitness tips</p>

  <a class="default-btn" href="<?php echo esc_url(home_url('/blog')); ?>">
  更多關於 JI Fitness blog
  </a>

  <?php
  $posts = get_field('home_page_blog_posts'); // ACF relationship field
  
  if( $posts ):
    foreach( $posts as $post ):
      setup_postdata($post); ?>
      
      <article id="home-post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <a href="<?php the_permalink(); ?>">
          <?php 
            if ( has_post_thumbnail() ) {
              the_post_thumbnail('landscape-blog');
            }
          ?>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </a>
      </article>
  
    <?php endforeach;
    wp_reset_postdata();?>

  <?php endif; ?>
</section>

</main>


<?php
echo "</div>";
get_footer();