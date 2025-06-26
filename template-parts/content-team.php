


<?php
$team_members = get_field('team_members');
if ($team_members):
?>
<section class="coaches-section" id="coaches">
  
  <h2 class="core-value-heading">
  <span class="zh">專業團隊</span><br>
  <span class="en">Team</span>
  </h2>

  <div class="coach-nav">
    <?php foreach ($team_members as $member): ?>
      <a href="#<?php echo esc_attr($member['coach_id']); ?>" class="coach-nav-item">
        <?php if (!empty($member['coach_thumbnail'])): ?>
          <img src="<?php echo esc_url($member['coach_thumbnail']['url']); ?>" alt="<?php echo esc_attr($member['coach_name']); ?>">
        <?php endif; ?>
        <p class="coach-nav-label"><?php echo esc_html($member['coach_title'] . ' ' . $member['coach_name']); ?></p>
      </a>
    <?php endforeach; ?>
  </div>

  <?php foreach ($team_members as $member): ?>
  <article class="coach-profile" id="<?php echo esc_attr($member['coach_id']); ?>">
    
    <div class="coach-layout">
      <!-- 左側：職稱、姓名、照片 -->
      <div class="coach-left">
        <p class="coach-title"><?php echo esc_html($member['coach_title']); ?></p>
        <h3 class="coach-name"><?php echo esc_html($member['coach_name']); ?></h3>

        <?php if (!empty($member['coach_image'])): ?>
          <div class="coach-photo">
            <img src="<?php echo esc_url($member['coach_image']['url']); ?>" alt="<?php echo esc_attr($member['coach_name']); ?>">
          </div>
        <?php endif; ?>
      </div>

      <!-- 右側：教練介紹 -->
      <div class="coach-right">
        <div class="coach-info">
          <?php echo wp_kses_post($member['coach_intro']); ?>
        </div>
      </div>
    </div>

    <!-- 引言區塊 -->
    <blockquote class="coach-quote-block">
      <div class="quote-icon" aria-hidden="true">
        <img src="<?php echo get_template_directory_uri(); ?>/images/quote-icon.webp" alt="">
      </div>
      <div class="quote-content">
        <p class="quote-text"><?php echo esc_html($member['coach_quote']); ?></p>
        <p class="quote-author"><?php echo esc_html($member['coach_title'] . ' ' . $member['coach_name']); ?></p>
      </div>
    </blockquote>

    <!-- 證照輪播（僅 Irene 有） -->
    <?php if (!empty($member['coach_certificates']) && $member['coach_id'] === 'irene'): ?>
      <div class="coach-cert-swiper swiper">
        <div class="swiper-wrapper">
          <?php foreach ($member['coach_certificates'] as $cert): ?>
            <div class="swiper-slide cert-slide">

              <div class="cert-content">
                <div class="cert-image">
                  <img src="<?php echo esc_url($cert['cert_image']['url']); ?>" alt="<?php echo esc_attr($cert['cert_image']['alt']); ?>">
                </div>

                <div class="cert-text">
                  <h4 class="cert-title"><?php echo esc_html($cert['cert_title']); ?></h4>
                  <p class="cert-desc"><?php echo esc_html($cert['cert_desc']); ?></p>
                </div>

                <div class="swiper-nav">
                  <div class="swiper-button-prev cert-prev"></div>
                  <div class="swiper-button-next cert-next"></div>
                </div>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </article>
<?php endforeach; ?>

</section>
<?php endif; ?>
