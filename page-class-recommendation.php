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
            <button type="button" class="btn next-step" data-next-step="step-2" disabled>下一步</button>
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
                <button type="button" class="btn prev-step" data-prev-step="step-1">上一步</button>
                <button type="button" class="btn next-step" data-next-step="step-3" disabled>查看推薦課程</button>
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
                <button type="button" class="btn prev-step" data-prev-step="step-2">重新選擇</button>
                <button type="button" class="btn restart-btn">重新開始</button>
            </div>
        </div>
    </form>
</div>
</main>

<?php
get_footer();