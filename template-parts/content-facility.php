<?php


$heading = get_field('facilities_and_rental_info_heading');
$features = get_field('facility_features');

if ($features) :
?>

<section class="facility-features">
  <div class="container">
    <?php if ($heading): ?>
      <h2 class="section-heading"><?php echo esc_html($heading); ?></h2>
    <?php endif; ?>

    <ul class="features-grid">
      <?php foreach ($features as $feature):
        $icon = $feature['facility_icon'];
        $label = $feature['facility_label'];
      ?>
        <li class="feature-item">
          <?php if ($icon): ?>
            <div class="icon">
              <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($label); ?>" />
            </div>
          <?php endif; ?>
          <?php if ($label): ?>
            <p><?php echo esc_html($label); ?></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
</section>

<?php endif; ?>
