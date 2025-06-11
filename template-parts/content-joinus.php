<?php
$join_us_group = get_field('join_us');

if ( $join_us_group ) :
  $join_heading = $join_us_group['join_heading'] ?? '';
  $join_image   = $join_us_group['join_image'] ?? '';
  $join_text    = $join_us_group['join_text'] ?? '';
?>
<section class="join-us-section" id="join-us">
  <div class="container">
    <div class="join-us-heading">
      <h2><?php echo esc_html($join_heading); ?></h2>
    </div>
    <div class="join-us-content">
      <div class="join-us-image">
        <?php if ( $join_image ) : ?>
          <img src="<?php echo esc_url($join_image['url']); ?>" alt="<?php echo esc_attr($join_image['alt']); ?>" />
        <?php endif; ?>
      </div>
      <div class="join-us-text-block">
        <p class="join-us-styling">JOIN OUR TEAM</p>
        <div class="join-us-body"><?php echo wp_kses_post($join_text); ?></div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
