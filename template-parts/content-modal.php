
<?php
// 从传入的参数中提取变量
extract($args);
?>

<!-- Testimonial Card (点击触发 Modal) -->
<article 
    data-modal-target="<?php echo esc_attr( $modal_id ); ?>" 
    data-modal-toggle="<?php echo esc_attr( $modal_id ); ?>"  
    class="cursor-pointer bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="h-48 overflow-hidden">
            <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover' ) ); ?>
        </div>
    <?php endif; ?>

    <div class="p-4">
        <h3 class="text-lg font-bold mb-2"><?php the_title(); ?></h3>
        <div class="text-gray-600 line-clamp-3">
            <?php the_excerpt(); ?>
        </div>
    </div>

</article>

<!-- Main modal -->
<div 
id="<?php echo esc_attr( $modal_id ); ?>" 
data-modal-backdrop="static"
tabindex="-1" aria-hidden="true" 
class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
>

<div class="relative p-4 w-full max-w-2xl max-h-full">
    
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                <?php the_title(); ?>
            </h3>
                <button 
                type="button" 
                class="text-gray-500 hover:text-gray-700" 
                data-modal-hide="<?php echo esc_attr( $modal_id ); ?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
        </div>

        <!-- Modal body -->
        <div class="p-8 md:p-5 space-y-6">
        <?php the_post_thumbnail('medium'); ?>
            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            <?php the_content(); ?>
            </p>
        </div>

        <!-- Modal footer -->
        <div class="p-4 border-t sticky bottom-0 bg-white dark:bg-gray-800">
        <button 
            data-modal-hide="<?php echo esc_attr($modal_id); ?>" 
            class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
            關閉
        </button>
        </div>

    </div>
</div>
</div>
        