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
        <!-- 步骤 1: 选择课程类型 -->
        <div class="step step-1 active" id="step-1">
            <h2>选择您的偏好的上课方式</h2>
            <div class="options">
                <label class="option-card">
                    <input type="radio" name="course_type" value="ji-1-on-1" required class="sr-only">
                    <div class="option-content">
                        <h3>一对一课程</h3>
                        <p>个性化指导，完全根据您的需求设计</p>
                    </div>
                </label>
                
                <label class="option-card">
                    <input type="radio" name="course_type" value="ji-small-group" required class="sr-only">
                    <div class="option-content">
                        <h3>小班团体课</h3>
                        <p>小组学习，享受团体动力与较低费用</p>
                    </div>
                </label>
                <label class="option-card">
                    <input type="radio" name="course_type" value="ji-online" required class="sr-only">
                    <div class="option-content">
                        <h3>線上</h3>
                        <p>xxxxxxx</p>
                    </div>
                </label>
            </div>
            <button type="button" class="btn next-step" data-next-step="step-2" disabled>下一步</button>
        </div>
        
        <!-- 步骤 2: 选择训练目标 -->
        <div class="step step-2" id="step-2">
            <h2>您的训练目标是什么？</h2>
            <div class="goal-selection">
                <div class="primary-goals">
                    <h3>主要目标</h3>
                    <div class="options" id="primary-goals">
                        <!-- 动态加载内容 -->
                        <div class="loading-spinner">加载训练目标中...</div>
                    </div>
                </div>
                
                <div class="secondary-goals">
                    <h3>次要目标 <small>(可选)</small></h3>
                    <div class="options" id="secondary-goals">
                        <p class="notice">请先选择主要目标</p>
                    </div>
                </div>
            </div>
            
            <div class="step-actions">
                <button type="button" class="btn prev-step" data-prev-step="step-1">上一步</button>
                <button type="button" class="btn next-step" data-next-step="step-3" disabled>查看推荐课程</button>
            </div>
        </div>
        
        <!-- 步骤 3: 推荐结果 -->
        <div class="step step-3" id="step-3">
            <h2>根据您的选择，我们推荐</h2>
            <div id="recommendation-results">
                <!-- 动态加载内容 -->
                <div class="loading-placeholder">正在为您生成推荐课程...</div>
            </div>
            
            <div class="step-actions">
                <button type="button" class="btn prev-step" data-prev-step="step-2">重新选择</button>
                <button type="button" class="btn restart-btn">重新开始</button>
            </div>
        </div>
    </form>
</div>
</main>

<?php
get_footer();