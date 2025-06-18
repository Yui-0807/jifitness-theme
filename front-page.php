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

<?php if( have_rows('home_page_class_info_1') ): ?>
  <?php while( have_rows('home_page_class_info_1') ): the_row(); 

    $one_on_one_class_description = get_sub_field('1_on_1_class_description');
    $small_group_link = get_sub_field('small_group_link');
    
    // 一對一課程
    if( $one_on_one_class_description instanceof WP_Post ):
      $post = $one_on_one_class_description; // 直接指定
      setup_postdata($post);
      $post_id = get_the_ID();
      ?>
      <article id="home-post-<?php the_ID(); ?>" <?php post_class();?>>
        <!-- class card image -->
        <?php
        $image = get_field('class_image');
        if ( $image ): ?>
            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="max-width:300px;" />
        <?php endif; ?>

        <!-- class card content -->
        <h3><?php the_title(); ?></h3>
        <?php if ( get_field('class_description') ): ?>
          <p class="home-class-description">
            <?php
              $class_description = get_field('class_description');
              $text_only = strip_tags($class_description);
              $short_description = wp_trim_words($text_only, 60, '...');
              echo '<div class="class-description">' . $short_description . '</div>';
            ?>
          </p>
        <?php endif; ?>

        <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1#1-on-1-' . $post_id)); ?>">
          一對一課程
        </a>
      </article>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <!-- 團體課程按鈕 -->
    <?php if( $small_group_link instanceof WP_Post ): ?>
      <?php
        $post = $small_group_link;
        setup_postdata($post);
        $post_id = get_the_ID();
      ?>
      <a class="default-btn" href="<?php echo esc_url(home_url('/small-group#small-group-' . $post_id)); ?>">
        團體課程
      </a>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

  <?php endwhile; ?>
<?php endif; ?>

<?php if( have_rows('home_page_class_info_2') ): ?>
  <?php while( have_rows('home_page_class_info_2') ): the_row(); 

    $one_on_one_class_description = get_sub_field('1_on_1_class_description');
    $small_group_link = get_sub_field('small_group_link');
    
    // 一對一課程
    if( $one_on_one_class_description instanceof WP_Post ):
      $post = $one_on_one_class_description; // 直接指定
      setup_postdata($post);
      $post_id = get_the_ID();
      ?>
      <article id="home-post-<?php the_ID(); ?>" <?php post_class();?>>
        <!-- class card image -->
        <?php
        $image = get_field('class_image');
        if ( $image ): ?>
            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="max-width:300px;" />
        <?php endif; ?>

        <!-- class card content -->
        <h3><?php the_title(); ?></h3>
        <?php if ( get_field('class_description') ): ?>
          <p class="home-class-description">
            <?php
              $class_description = get_field('class_description');
              $text_only = strip_tags($class_description);
              $short_description = wp_trim_words($text_only, 60, '...');
              echo '<div class="class-description">' . $short_description . '</div>';
            ?>
          </p>
        <?php endif; ?>

        <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1#1-on-1-' . $post_id)); ?>">
          一對一課程
        </a>
      </article>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <!-- 團體課程按鈕 -->
    <?php if( $small_group_link instanceof WP_Post ): ?>
      <?php
        $post = $small_group_link;
        setup_postdata($post);
        $post_id = get_the_ID();
      ?>
      <a class="default-btn" href="<?php echo esc_url(home_url('/small-group#small-group-' . $post_id)); ?>">
        團體課程
      </a>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    
  <?php endwhile; ?>
<?php endif; ?>

<?php if( have_rows('home_page_class_info_3') ): ?>
  <?php while( have_rows('home_page_class_info_3') ): the_row(); 

    $one_on_one_class_description = get_sub_field('1_on_1_class_description');
    $small_group_link = get_sub_field('small_group_link');
    
    // 一對一課程
    if( $one_on_one_class_description instanceof WP_Post ):
      $post = $one_on_one_class_description; // 直接指定
      setup_postdata($post);
      $post_id = get_the_ID();
      ?>
      <article id="home-post-<?php the_ID(); ?>" <?php post_class();?>>
        <!-- class card image -->
        <?php
        $image = get_field('class_image');
        if ( $image ): ?>
            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" style="max-width:300px;" />
        <?php endif; ?>

        <!-- class card content -->
        <h3><?php the_title(); ?></h3>
        <?php if ( get_field('class_description') ): ?>
          <p class="home-class-description">
            <?php
              $class_description = get_field('class_description');
              $text_only = strip_tags($class_description);
              $short_description = wp_trim_words($text_only, 60, '...');
              echo '<div class="class-description">' . $short_description . '</div>';
            ?>
          </p>
        <?php endif; ?>

        <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1#1-on-1-' . $post_id)); ?>">
          一對一課程
        </a>
      </article>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <!-- 團體課程按鈕 -->
    <?php if( $small_group_link instanceof WP_Post ): ?>
      <?php
        $post = $small_group_link;
        setup_postdata($post);
        $post_id = get_the_ID();
      ?>
      <a class="default-btn" href="<?php echo esc_url(home_url('/small-group#small-group-' . $post_id)); ?>">
        團體課程
      </a>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    
  <?php endwhile; ?>
<?php endif; ?>
  <a class="default-btn" href="<?php echo esc_url(home_url('/1-on-1')); ?>">了解更多課程</a>
  <a class="default-btn" href="<?php echo esc_url(home_url('/class-recommendation')); ?>">找尋適合我的課程</a>
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