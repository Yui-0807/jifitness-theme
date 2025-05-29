jQuery(document).ready(function($) {
    const apiBaseUrl = `${window.location.origin}/wp-json/wp/v2`;
    let allTrainingGoals = [];
    
    // 下一步按钮点击事件
    $(document).on('click', '.next-step', function() {
        const currentStep = $(this).closest('.step');
        const nextStep = currentStep.next('.step');
        
        currentStep.removeClass('active');
        nextStep.addClass('active');
        
        if (currentStep.hasClass('step-1') && nextStep.hasClass('step-2')) {
            loadTrainingGoals();
        }
    });
    
    // 加载训练目标
    function loadTrainingGoals() {
        const courseType = $('input[name="course_type"]:checked').val();
        if (!courseType) {
            alert('请先选择课程类型');
            return;
        }
        
        fetchTrainingGoals()
            .then(goals => {
                allTrainingGoals = goals;
                renderGoalOptions(goals);
            })
            .catch(error => {
                console.error('Error:', error);
                showError('加载失败，请刷新页面重试');
            });
    }
    
    // 使用 Fetch API 获取训练目标
    function fetchTrainingGoals() {
        return fetch(`${apiBaseUrl}/ji-training-goal`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error('Invalid data format');
                }
                return data;
            });
    }
    
    // 获取推荐课程
    function fetchRecommendedCourses(courseType, primaryGoal, secondaryGoal = null) {
        let url = `${apiBaseUrl}/recommended-courses?course_type=${encodeURIComponent(courseType)}&primary_goal=${primaryGoal}`;
        
        if (secondaryGoal) {
            url += `&secondary_goal=${secondaryGoal}`;
        }
        
        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            });
    }
    
    // 渲染目标选项
    function renderGoalOptions(goals) {
        let html = '';
        
        if (goals.length === 0) {
            html = '<p>没有可用的训练目标</p>';
        } else {
            goals.forEach(goal => {
                html += `
                <label class="option-card goal-option">
                    <input type="radio" name="primary_goal" value="${goal.id}" class="sr-only" required>
                    <div class="option-content">
                        <h4>${goal.name}</h4>
                        ${goal.description ? `<p>${goal.description}</p>` : ''}
                    </div>
                </label>`;
            });
        }
        
        $('#primary-goals').html(html);
        $('.step-2 .next-step').prop('disabled', true);
    }
    
    // 显示错误信息
    function showError(message) {
        $('#primary-goals').html(`<div class="error">${message}</div>`);
    }
    
    // 当主要目标被选择时，启用下一步按钮
    $(document).on('change', 'input[name="primary_goal"]', function() {
        $('.step-2 .next-step').prop('disabled', false);
    });
    
    // 表单提交获取推荐课程
    $(document).on('click', '.step-3 .get-recommendations', function() {
        const courseType = $('input[name="course_type"]:checked').val();
        const primaryGoal = $('input[name="primary_goal"]:checked').val();
        const secondaryGoal = $('input[name="secondary_goal"]:checked').val();
        
        fetchRecommendedCourses(courseType, primaryGoal, secondaryGoal)
            .then(courses => {
                renderRecommendedCourses(courses);
            })
            .catch(error => {
                console.error('Error:', error);
                $('#recommendation-results').html('<div class="error">获取推荐课程失败</div>');
            });
    });
});