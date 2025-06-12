jQuery(document).ready(function($) {
    const { apiBaseUrl, nonce, translations } = jiRecommendation;

    updateNextButtonState();

    // 步骤一选择课程类型
    $('input[name="course_selection"]').on('change', function() {
        updateNextButtonState();
    });

    // 下一步按鈕
    $(document).on('click', '.next-step:not(:disabled)', function(e) {
        e.preventDefault();
        const $button = $(this);
        const currentStep = $button.closest('.step');
        const nextStepId = $button.data('next-step');
        const nextStep = $(`#${nextStepId}`);

        if (!nextStepId) return;

        // 步骤 1 → 步骤 2
        if (currentStep.hasClass('step-1') && nextStep.hasClass('step-2')) {
            const selectedValue = $('input[name="course_selection"]:checked').val();

            if (!selectedValue) {
                alert(translations.selectCourseType);
                return;
            }

            const [courseType, deliveryMethod] = selectedValue.split('|');
            window.selectedCourseType = courseType;
            window.selectedDeliveryMethod = deliveryMethod;

            $button.prop('disabled', true).html('<span class="spinner">↻</span> 加载中...');

            loadTrainingGoals()
                .then(() => {
                    toggleSteps(currentStep, nextStep);
                    $('input[name="primary_goal"]').on('change', function () {
                        $('.step-2 .next-step').prop('disabled', false);
                        loadSecondaryGoals($(this).val());
                    });
                })
                .catch(error => {
                    console.error('加载失败:', error);
                    alert(translations.loadingError);
                })
                .finally(() => {
                    $button.prop('disabled', false).text('下一步');
                });
        }

        // 步骤 2 → 步骤 3
        else if (currentStep.hasClass('step-2') && nextStep.hasClass('step-3')) {
            const primaryGoal = $('input[name="primary_goal"]:checked').val();
            const secondaryGoal = $('input[name="secondary_goal"]:checked').val();

            if (!primaryGoal) {
                alert('请选择主要目标');
                return;
            }

            $('#recommendation-results').html('<div class="loading-placeholder">正在为您生成推荐课程...</div>');

            $.ajax({
                url: `${apiBaseUrl}/recommended-courses`,
                method: 'GET',
                headers: { 'X-WP-Nonce': nonce },
                data: {
                    course_type: window.selectedCourseType,
                    delivery_method: window.selectedDeliveryMethod,
                    primary_goal: primaryGoal,
                    secondary_goal: secondaryGoal || ''
                },
                success: function (courses) {
                    if (!courses || courses.length === 0) {
                        $('#recommendation-results').html('<p>没有符合条件的推荐课程。</p>');
                        return;
                    }

                    const html = courses.map(course => {
                        const typeSlug = course.type === 'ji-1-on-1' ? '1-on-1' : 'small-group';
                        const anchorLink = `${course.category_link}#${typeSlug}-${course.id}`;
                        return `
                            <div class="recommendation-card">
                                <h4>${course.title}</h4>
                                <p>${course.description || ''}</p>
                                <a href="${anchorLink}" target="_blank">查看詳情</a>
                            </div>
                        `;
                    }).join('');
                    
                    $('#recommendation-results').html(html);
                },
                error: function () {
                    $('#recommendation-results').html(`<p>${translations.loadingError}</p>`);
                }
            });

            toggleSteps(currentStep, nextStep);
        }

        // 其他步驟切換
        else {
            toggleSteps(currentStep, nextStep);
        }
    });

    // 上一步
    $(document).on('click', '.prev-step', function () {
        const $button = $(this);
        const currentStep = $button.closest('.step');
        const prevStepId = $button.data('prev-step');
        const prevStep = $(`#${prevStepId}`);

        if (prevStep.length) {
            currentStep.removeClass('active');
            prevStep.removeClass('completed').addClass('active');
            $('html, body').animate({ scrollTop: prevStep.offset().top - 100 }, 300);
        }
    });

    // 重新開始
    $(document).on('click', '.restart-btn', function () {
        $('#course-recommendation-form')[0].reset();
        $('.step').removeClass('active completed');
        $('#step-1').addClass('active');
        $('#primary-goals, #secondary-goals, #recommendation-results').empty().html('');
        updateNextButtonState();
        $('html, body').animate({ scrollTop: 0 }, 300);
    });

    // 更新下一步按鈕狀態
    function updateNextButtonState() {
        const selected = $('input[name="course_selection"]:checked').length > 0;
        $('.step-1 .next-step').prop('disabled', !selected);
    }

    // 加載主目標
    function loadTrainingGoals() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiBaseUrl}/training-goals`,
                method: 'GET',
                headers: { 'X-WP-Nonce': nonce },
                success: function(goals) {
                    if (goals && goals.length > 0) {
    
                        // 這裡加過濾邏輯👇
                        let filteredGoals = goals;
                        if (window.selectedCourseType === 'ji-small-group') {
                            const excludedForSmallGroup = ['癌後體適能運動', '防身技巧'];
                            filteredGoals = goals.filter(goal => !excludedForSmallGroup.includes(goal.name));
                        }
    
                        renderGoalOptions(filteredGoals);
                        resolve();
                    } else {
                        reject(new Error('没有可用的训练目标'));
                    }
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }
    

    // 定義互斥規則：primaryId => 不要出現哪些 secondaryId
    const exclusionRules = {
        '防身技巧': ['癌後體適能運動'],
        '癌後體適能運動': ['防身技巧']
    };

    // 加載次要目標
    function loadSecondaryGoals(primaryId) {
        $.ajax({
            url: `${apiBaseUrl}/training-goals`,
            method: 'GET',
            headers: { 'X-WP-Nonce': nonce },
            success: function(goals) {
                const $secondary = $('#secondary-goals');
                $secondary.empty();
    
                // 找出 primary name
                const primaryGoal = goals.find(g => g.id == primaryId);
                const primaryName = primaryGoal ? primaryGoal.name : '';
    
                // 互斥邏輯
                const excludedNamesFromPrimary = exclusionRules[primaryName] || [];
    
                // 小團課固定要排除的目標
                const excludedForSmallGroup = (window.selectedCourseType === 'ji-small-group')
                    ? ['癌後體適能運動', '防身技巧']
                    : [];
    
                // 過濾次要目標
                const secondary = goals.filter(g => 
                    g.id != primaryId &&
                    !excludedNamesFromPrimary.includes(g.name) &&
                    !excludedForSmallGroup.includes(g.name)
                );
    
                if (secondary.length === 0) {
                    $secondary.html('<p>无可选的次要目标</p>');
                    return;
                }
    
                secondary.forEach(goal => {
                    $secondary.append(`
                        <label class="option-card goal-option">
                            <input type="radio" name="secondary_goal" value="${goal.id}">
                            <div class="option-content">
                                <p>${goal.name}</p>
                            </div>
                        </label>
                    `);
                });
            }
        });
    }
    

    // 渲染主目標
    function renderGoalOptions(goals) {
        const $container = $('#primary-goals');
        $container.empty();

        goals.forEach(goal => {
            $container.append(`
                <label class="option-card goal-option">
                    <input type="radio" name="primary_goal" value="${goal.id}" required>
                    <div class="option-content">
                        <p>${goal.name}</p>
                        ${goal.description ? `<p>${goal.description}</p>` : ''}
                    </div>
                </label>
            `);
        });
    }

    // 切換步驟
    function toggleSteps(current, next) {
        current.removeClass('active').addClass('completed');
        next.addClass('active');

        $('html, body').animate({
            scrollTop: next.offset().top - 100
        }, 300);
    }
});
