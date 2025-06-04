<?php

if ( ! function_exists( 'get_field' ) ) {
    return;
}
?>

<section class="rental-pricing-section">
  <div class="container">

    <?php if (have_rows('pricing_sections')) : ?>
      <div class="pricing-table">
        <?php while (have_rows('pricing_sections')) : the_row(); ?>
          <?php
            $venue_name = get_sub_field('venue_name');
          ?>
          <div class="venue-block">
            <h3 class="venue-title"><?php echo esc_html($venue_name); ?></h3>

            <!-- 租借費用 -->
            <?php if (have_rows('rental_fees')) : ?>
              <table class="rental-fee-table">
                <thead>
                  <tr>
                    <th>租借時數</th>
                    <th>價格</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while (have_rows('rental_fees')) : the_row(); ?>
                    <tr>
                      <td><?php the_sub_field('duration'); ?></td>
                      <td><?php the_sub_field('price'); ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php endif; ?>

            <!-- 場地細節 -->
            <?php if (have_rows('equipment_description')) : ?>
              <div class="equipment-description">
                <h4>場地設備</h4>
                <div class="equipment-grid">
                  <?php while (have_rows('equipment_description')) : the_row(); ?>
                    <?php
                      $floor_name = get_sub_field('floor_name');
                      $floor_items = get_sub_field('items');
                    ?>
                    <div class="equipment-floor">
                      <h5><?php echo esc_html($floor_name); ?></h5>
                      <div class="floor-items">
                        <?php echo $floor_items; ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
