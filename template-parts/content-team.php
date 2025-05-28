<?php
$team_members = get_field('team_members');
if ($team_members):
?>
<section class="coaches" id="coaches">

  <!-- 導覽縮圖區 -->
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

  <!-- 教練內容區 -->
  <?php foreach ($team_members as $member): ?>
    <div class="coach-profile" id="<?php echo esc_attr($member['coach_id']); ?>">
      <h3><?php echo esc_html($member['coach_title'] . ' ' . $member['coach_name']); ?></h3>

      <?php if (!empty($member['coach_image'])): ?>
        <img src="<?php echo esc_url($member['coach_image']['url']); ?>" alt="<?php echo esc_attr($member['coach_name']); ?>">
      <?php endif; ?>

      <div class="coach-info">
        <?php echo wp_kses_post($member['coach_intro']); ?>
      </div>

      <?php if (!empty($member['coach_quote'])): ?>
        <blockquote>
          <p><?php echo esc_html($member['coach_quote']); ?></p>
        </blockquote>
      <?php endif; ?>

      <?php if (!empty($member['coach_certificates']) && $member['coach_id'] === 'irene'): ?>
        <div class="coach-cert-carousel">
          <?php foreach ($member['coach_certificates'] as $cert): ?>
            <div class="cert-slide">
              <img src="<?php echo esc_url($cert['url']); ?>" alt="<?php echo esc_attr($cert['alt']); ?>">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</section>
<?php endif; ?>
