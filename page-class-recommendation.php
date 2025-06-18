<?php
/**
 * The template for displaying the class-recommendation page
 */
get_header();
?>

<main id="primary" class="site-main">
   <?php get_template_part('template-parts/content', 'banner'); ?>
          
   <div class="course-recommendation-container">
    <form id="course-recommendation-form">
        <!-- 步驟 1: 選擇課程類型 -->
        <div class="step step-1 active" id="step-1">
            <h2>選擇您偏好的上課方式</h2>
            <div class="options">
                <label class="option-card">
                    <input type="radio" name="course_selection" value="ji-1-on-1|in-person" required class="sr-only">
                    <div class="option-content">
                        <h3>一對一課程</h3>
                        <p>個性化指導，面對面上課</p>
                    </div>
                </label>
                
                <label class="option-card">
                    <input type="radio" name="course_selection" value="ji-small-group|in-person" required class="sr-only">
                    <div class="option-content">
                        <h3>小班團體課</h3>
                        <p>小組學習，面對面上課</p>
                    </div>
                </label>

                <label class="option-card">
                    <input type="radio" name="course_selection" value="ji-1-on-1|online" required class="sr-only">
                    <div class="option-content">
                        <h3>線上課程</h3>
                        <p>一對一線上授課</p>
                    </div>
                </label>
            </div>
            <button type="button" class="default-btn next-step" data-next-step="step-2" disabled>下一步</button>
        </div>

        <!-- 步驟 2: 選擇訓練目標 -->
        <div class="step step-2" id="step-2">
            <h2>您的訓練目標是什麼？</h2>
            <div class="goal-selection">
                <div class="primary-goals">
                    <h3>主要目標</h3>
                    <div class="options" id="primary-goals">
                        <!-- 動態加載內容 -->
                        <div class="loading-spinner">加載訓練目標中...</div>
                    </div>
                </div>
                
                <div class="secondary-goals">
                    <h3>次要目標 <small>(可選)</small></h3>
                    <div class="options" id="secondary-goals">
                        <p class="notice">請先選擇主要目標</p>
                    </div>
                </div>
            </div>
            
            <div class="step-actions">
                <button type="button" class="default-btn prev-step" data-prev-step="step-1">上一步</button>
                <button type="button" class="default-btn next-step" data-next-step="step-3" disabled>查看推薦課程</button>
            </div>
        </div>
        
        <!-- 步驟 3: 推薦結果 -->
        <div class="step step-3" id="step-3">
            <h2>根據您的選擇，我們推薦</h2>
            <div id="recommendation-results">
                <!-- 動態加載內容 -->
                <div class="loading-placeholder">正在為您生成推薦課程...</div>
            </div>
            
            <div class="step-actions">
                <button type="button" class="default-btn prev-step" data-prev-step="step-2">上一步</button>
                <button type="button" class="default-btn restart-btn">重新開始</button>
            </div>
        </div>
    </form>
</div>

<section class="registration-process">

<?php
if (have_rows('registration_process')) :

    echo '<h2>報名流程</h2>';
    echo '<div class="registration-steps">';

    $steps = get_field('registration_process'); // 取得整個 repeater 的陣列
    $total_steps = count($steps);

    foreach ($steps as $index => $step) {
        $step_num = $index + 1;
        $step_description = $step['step_description'];

        echo '<div class="registration-step">';
        echo '<h3 class="step-number"><span>Step ' . $step_num . '</span></h3>';
        echo '<p class="step-description">' . esc_html($step_description) . '</p>';
        echo '</div>';

        // 只有在不是最後一筆時顯示箭頭
        if ($step_num < $total_steps) {
            echo '<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m16.843 10.211c.108-.141.157-.3.157-.456 0-.389-.306-.755-.749-.755h-8.501c-.445 0-.75.367-.75.755 0 .157.05.316.159.457 1.203 1.554 3.252 4.199 4.258 5.498.142.184.36.29.592.29.23 0 .449-.107.591-.291 1.002-1.299 3.044-3.945 4.243-5.498z"/></svg>';
        }
    }

    echo '</div>';

    // 顯示表單與 LINE 按鈕
    $menu = wp_get_nav_menu_object('footer-social-media');

    if (have_rows('social_media', $menu)) {
        while (have_rows('social_media', $menu)) {
            the_row();

            $social_media_links = get_sub_field('social_media_links');
            $category = get_sub_field('category');
           
            if ($category === 'google-form') {
                echo '<a class="default-btn" href="' . esc_url($social_media_links) . '" target="_blank" rel="noopener noreferrer">表單填寫</a>';
            }
            if ($category === 'line') {
                echo '<a class="default-btn" href="' . esc_url($social_media_links) . '" target="_blank" rel="noopener noreferrer">官方LINE@</a>';
            }
        }
    }

    

endif;
?>

</section>
</main>

<?php
get_footer();