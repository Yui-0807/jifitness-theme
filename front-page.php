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

<!-- Carousel Banners -->
<div class="home-banner-bg">
<?php get_template_part('template-parts/content', 'banner'); ?>
<div class="home-banner-wave"></div>
</div>
<div class="cotent-container">
<main id="primary" class="site-main">

<!-- manifesto -->
<div class="home-manifesto-bg">
<?php
$about_page = get_page_by_path('about'); // 假設關於頁面的 slug 是 'about'
set_query_var('manifesto_page_id', $about_page->ID);
get_template_part( 'template-parts/content', 'manifesto' );
?>
</div>

<!-- Fitness Classes -->
<div class="home-class-bg">
  <div class="bg-top"></div>
  <div class="bg-mid"></div>
  <div class="bg-bottom"></div>
<section class="home-class">
    <h2 class="home-class-heading">課程介紹<span>Fitness Classes</span></h2>
<div class="home-class-wrapper">
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
        <article class="default-card" id="home-post-<?php echo $one_on_one->ID; ?>">
          <?php if ( $image ): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <?php endif; ?>
          <h3><?php echo get_the_title($one_on_one); ?></h3>
          <?php if ($desc): ?>
            <p class="home-class-description">
                <?php echo wp_trim_words(strip_tags($desc), 60, '...'); ?>
            </p>
          <?php endif; ?>
          <div class="home-class-btns">
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
          </div>
        </article>
    <?php endwhile; ?>
  <?php endif;
endforeach;
?>
</div>
<div class="home-class-section-btn" >
  <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1')); ?>">了解更多課程</a>
  <a class="default-btn" href="<?php echo esc_url(home_url('/class-recommendation')); ?>">找尋適合我的課程</a>
</div>
</section>
</div>

<!-- Testimonials -->
<div class="home-testimonials-bg">
<section class="home-testimonials">
  <h2 class="home-testimonials-heading">學員推薦<span>Get inspired by our members</span></h2>
  <div class="modals">
    <?php
    $testimonials = get_field('home_page_testimonials'); // ACF relationship

    if ( $testimonials ):
      foreach ( $testimonials as $post ):
        setup_postdata($post);
        $post_id = get_the_ID(); ?>

        <!-- Modal -->
        <?php get_template_part( 'template-parts/content', 'testimonials-card' ); ?>
        
    <?php
      endforeach;
      wp_reset_postdata();?>
    <?php endif; ?>
  </div>
  <a class="default-btn home-testimonials-btn" href="<?php echo esc_url(home_url('/testimonials')); ?>">
  更多關於 JI Fitness 學員推薦
  </a>
</section>
    </div>

<!-- Mood Section -->
<section class="mood-wrapper">
<?php get_template_part('template-parts/content', 'mood'); ?>
</section>


<!-- Blog -->
<div class="home-blog-bg">
<section class="home-blog">
  <div class="home-blog-left">
    <h2 class="home-blog-heading">Irene 教練小教室<span>Blog for fitness tips</span></h2>
    <a class="default-btn home-blog-btn" 
      href="<?php echo esc_url(home_url('/blog')); ?>">
    更多關於 JI Fitness blog
    </a>
  </div>

  <div class="swiper blog-swiper">
  <div class="swiper-wrapper">
    <?php
    $posts = get_field('home_page_blog_posts'); // ACF relationship field
    
    if( $posts ):
      foreach( $posts as $post ):
        setup_postdata($post); ?>
        
        <div class="swiper-slide">
          <article class="default-card" id="home-post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>">
              <?php 
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail('landscape-blog');
                }
              ?>
              <h3><?php the_title(); ?></h3>
              <?php 
              $excerpt = get_the_excerpt();
              $trimmed_excerpt = wp_trim_words( $excerpt, 40, '...' );
              echo '<p>' . esc_html( $trimmed_excerpt ) . '</p>';
              ?>
            </a>
          </article>
        </div>

      <?php endforeach;
      wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>
  <div class="blog-btn">
    <div class="blog-prev">
      <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z" fill-rule="nonzero"/></svg>
    </div>
    <div class="blog-next">
      <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>
    </div>
  </div>
</div>
</section>
</div>

<!-- FAQ Section -->
<?php if ( have_rows('faq_items') ) : ?>
<section class="faq-section">
  <div class="container">
    <h2 class="faq-heading">常見問題<span>Frequently Asked Questions</span></h2>
    <div class="faq-accordion">
      <?php while ( have_rows('faq_items') ) : the_row(); ?>
        <?php 
          $question = get_sub_field('question');
          $answer   = get_sub_field('answer');
        ?>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span class="faq-text"><?php echo esc_html($question); ?></span>
            <span class="faq-icon" aria-hidden="true">+</span>
          </button>
          <div class="faq-answer">
            <?php echo wp_kses_post($answer); ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif; ?>


</main>


<?php
echo "</div>";
get_footer();