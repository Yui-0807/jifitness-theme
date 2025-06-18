<?php
$image = get_field('mood_image');
$headline_en = get_field('mood_headline_en');
$quote_en = get_field('mood_quote_en');
$quote_zh = get_field('mood_quote_zh');
?>

<?php if ($image): ?>
  <div class="mood-section" style="background-image: url('<?php echo esc_url($image['url']); ?>');">
    <div class="mood-overlay">
      <?php if ($headline_en): ?>
        <h2 class="mood-heading"><?php echo esc_html($headline_en); ?></h2>
      <?php endif; ?>

      <?php if ($quote_en): ?>
        <p class="quote-en">"<?php echo esc_html($quote_en); ?>"</p>
      <?php endif; ?>

      <?php if ($quote_zh): ?>
        <p class="quote-zh"><?php echo esc_html($quote_zh); ?></p>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
