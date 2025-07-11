<div class="about-deco"></div>

<?php
$images = get_field('studio_environment_gallery');
if ($images) : ?>
<section class="studio-environment-gallery" id="studio-environment-gallery">
  <div class="container">

    <h2 class="studio-env-heading">環境設施<span>Studio Environment</span></h2>

    <!-- Swiper 輪播（小螢幕用） -->
    <div class="swiper studio-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($images as $image) : ?>
          <div class="swiper-slide gallery-item">
            <img 
              src="<?php echo esc_url($image['sizes']['large']); ?>" 
              alt="<?php echo esc_attr($image['alt']); ?>" 
              loading="lazy" />
            <?php if (!empty($image['caption'])) : ?>
              <p class="image-caption"><?php echo esc_html($image['caption']); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 瀑布流（大螢幕用） -->
    <div class="gallery-grid">
      <?php foreach ($images as $image) : ?>
        <div class="gallery-item">
          <img 
            src="<?php echo esc_url($image['sizes']['large']); ?>" 
            alt="<?php echo esc_attr($image['alt']); ?>" 
            loading="lazy" />
          <?php if (!empty($image['caption'])) : ?>
            <p class="image-caption"><?php echo esc_html($image['caption']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
