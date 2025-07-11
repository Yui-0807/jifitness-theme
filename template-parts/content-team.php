<div class="about-deco"></div>

<?php
$team_members = get_field('team_members');
if ($team_members):
?>
<section class="coaches-section" id="coaches">
  
  <h2 class="team-heading">專業團隊<span>Team</span></h2>

  <div class="coach-nav">
    <?php foreach ($team_members as $member): ?>
      <a href="#<?php echo esc_attr($member['coach_id']); ?>" class="coach-nav-item">
        <svg viewBox="0 0 100 100" class="coach-avatar-svg" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <clipPath id="clip-<?php echo esc_attr($member['coach_id']); ?>">
              <path d="M82,59Q67,81,45,78Q23,75,20,54Q17,33,35,22Q53,11,71,26Q89,41,82,59Z"/>
            </clipPath>
          </defs>

          <!-- Blob 藍框（預設透明，hover 顯示）-->
          <path class="avatar-border"
                d="M82,59Q67,81,45,78Q23,75,20,54Q17,33,35,22Q53,11,71,26Q89,41,82,59Z"
                fill="none" stroke="#07699E" stroke-width="5" opacity="0"/>

          <!-- 圖片 -->
          <?php if (!empty($member['coach_thumbnail'])): ?>
            <image
              xlink:href="<?php echo esc_url($member['coach_thumbnail']['url']); ?>"
              x="0" y="0" width="100" height="100"
              clip-path="url(#clip-<?php echo esc_attr($member['coach_id']); ?>)"
              preserveAspectRatio="xMidYMid slice"
            />
          <?php endif; ?>
        </svg>

        <p class="coach-nav-label">
          <span class="coach-title"><?php echo esc_html($member['coach_title']); ?></span><br>
          <span class="coach-name"><?php echo esc_html($member['coach_name']); ?></span>
        </p>
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
