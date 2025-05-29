<?php
/**
 * The template for displaying the class-recommendation page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Jifitness_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

   <?php get_template_part( 'template-parts/content', 'banner' ); ?>
          
   <div class="course-recommendation-container">
    <form id="course-recommendation-form">
        <!-- 步驟 1: 選擇課程類型 -->
        <div class="step step-1 active">
            <h2>選擇您的偏好的上課方式</h2>
            <div class="options">
                <label class="option-card">
                    <input type="radio" name="course_type" value="one_on_one" class="sr-only">
                    <div class="option-content">
                        <h3>一對一課程</h3>
                        <p>個人化指導，完全根據您的需求設計</p>
                    </div>
                </label>
                
                <label class="option-card">
                    <input type="radio" name="course_type" value="small_group" class="sr-only">
                    <div class="option-content">
                        <h3>小班團體課</h3>
                        <p>小組學習，享受團體動力與較低費用</p>
                    </div>
                </label>
            </div>
            <button type="button" class="btn next-step" disabled>下一步</button>
        </div>
        
        <!-- 步驟 2: 選擇訓練目標 -->
        <div class="step step-2">
            <h2>您的訓練目標是什麼？</h2>
            <div class="goal-selection">
                <div class="primary-goals">
                    <h3>主要目標</h3>
                    <div class="options" id="primary-goals">
                        <?php 
                        // 從 taxonomy 獲取所有訓練目標
                        $goals = get_terms(array(
                            'taxonomy' => 'training_goal',
                            'hide_empty' => false,
                        ));
                        
                        if ($goals && !is_wp_error($goals)) {
                            foreach ($goals as $goal) {
                                echo '<label class="option-card goal-option">
                                    <input type="radio" name="primary_goal" value="' . $goal->term_id . '" class="sr-only">
                                    <div class="option-content">
                                        <h4>' . $goal->name . '</h4>
                                        <p>' . $goal->description . '</p>
                                    </div>
                                </label>';
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="secondary-goals">
                    <h3>次要目標 <small>(可選)</small></h3>
                    <div class="options" id="secondary-goals">
                        <!-- 這裡會動態載入不重複的次要目標選項 -->
                        <p class="notice">請先選擇主要目標</p>
                    </div>
                </div>
            </div>
            
            <div class="step-actions">
                <button type="button" class="btn prev-step">上一步</button>
                <button type="button" class="btn next-step" disabled>查看推薦課程</button>
            </div>
        </div>
        
        <!-- 步驟 3: 推薦結果 -->
        <div class="step result">
            <h2>根據您的選擇，我們推薦</h2>
            <div id="recommendation-content">
                <!-- 這裡會動態顯示推薦課程 -->
            </div>
            
            <div class="step-actions">
                <button type="button" class="btn prev-step">重新選擇</button>
            </div>
        </div>
    </form>
</div>

   
    
</main>

<?php
get_footer();