<div class="default-card testimonial-card">
    <label for="modal-<?php echo get_the_ID(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <div class="testimonial-card__image">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto']); ?>
            </div>
        <?php endif; ?>
        <div class="testimonial-card__content">
            <h2><?php the_title(); ?></h2>
            <div class="testimonial-card_hashtag">
                <?php if (have_rows('testimoniales_hashtag')) :
                    while (have_rows('testimoniales_hashtag')) : the_row();
                        $hashtag = get_sub_field('hashtag');
                        if ($hashtag): ?>
                            <a class="hashtag" href="<?php echo esc_url($hashtag['url']); ?>">
                                <?php echo esc_html($hashtag['title']); ?>
                            </a>
                        <?php endif;
                    endwhile;
                endif; ?>
            </div>
            <?php the_excerpt(); ?>
        </div>
    </label>
</div>

<!-- Modal -->
<input type="checkbox" id="modal-<?php echo get_the_ID(); ?>" class="modal-state">
<div class="modal">
    <label for="modal-<?php echo get_the_ID(); ?>" class="modal__bg"></label>
    <div class="modal__inner">
        <label class="modal__close" for="modal-<?php echo get_the_ID(); ?>"></label>
        <?php the_post_thumbnail('large'); ?>
        <div class="modal__content">
            <h2><?php the_title(); ?></h2>
            <div class="modal__hashtag">
                <?php if (have_rows('testimoniales_hashtag')) :
                    while (have_rows('testimoniales_hashtag')) : the_row();
                        $hashtag = get_sub_field('hashtag');
                        if ($hashtag): ?>
                            <a class="hashtag" href="<?php echo esc_url($hashtag['url']); ?>">
                                <?php echo esc_html($hashtag['title']); ?>
                            </a>
                        <?php endif;
                    endwhile;
                endif; ?>
            </div>
            <?php the_content(); ?>
        </div>
    </div>
</div>
