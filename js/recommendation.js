jQuery(document).ready(function($) {
    const { apiBaseUrl, nonce, translations } = jiRecommendation;

    updateNextButtonState();

    // 步驟一：選擇課程類型
    $('input[name="course_type"]').on('change', function() {
        updateNextButtonState();
    });

    // 下一步按鈕點擊
    $(document).on('click', '.next-step:not(:disabled)', function(e) {
        e.preventDefault();
        const $button = $(this);
        const currentStep = $button.closest('.step');
        const nextStepId = $button.data('next-step');
        const nextStep = $(`#${nextStepId}`);

        if (!nextStepId) return;

        // 第一步 → 第二步：加載目標
        if (currentStep.hasClass('step-1') && nextStep.hasClass('step-2')) {
            const courseType = $('input[name="course_type"]:checked').val();

            if (!courseType) {
                alert(translations.selectCourseType);
                return;
            }

            $button.prop('disabled', true).html('<span class="spinner">↻</span> 加载中...');

            loadTrainingGoals(courseType)
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

        // 第二步 → 第三步：取得推薦
        else if (currentStep.hasClass('step-2') && nextStep.hasClass('step-3')) {
            const primaryGoal = $('input[name="primary_goal"]:checked').val();
            const secondaryGoal = $('input[name="secondary_goal"]:checked').val();
            const courseType = $('input[name="course_type"]:checked').val();

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
                    course_type: courseType,
                    primary_goal: primaryGoal,
                    secondary_goal: secondaryGoal || ''
                },
                success: function (courses) {
                    if (!courses || courses.length === 0) {
                        $('#recommendation-results').html('<p>没有符合条件的推荐课程。</p>');
                        return;
                    }

                    const html = courses.map(course => `
                    <div class="recommendation-card">
                        <h4>${course.title}</h4>
                    </div>
                    `).join('');

                    $('#recommendation-results').html(html);
                },
                error: function () {
                    $('#recommendation-results').html(`<p>${translations.loadingError}</p>`);
                }
            });

            toggleSteps(currentStep, nextStep);
        }

        // 其他一般步驟切換
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

    // 判斷是否啟用下一步（step 1）
    function updateNextButtonState() {
        const courseTypeSelected = $('input[name="course_type"]:checked').length > 0;
        $('.step-1 .next-step').prop('disabled', !courseTypeSelected);
    }

    // 加載主目標
    function loadTrainingGoals(courseType) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiBaseUrl}/training-goals`,
                method: 'GET',
                headers: { 'X-WP-Nonce': nonce },
                data: { course_type: courseType },
                success: function(goals) {
                    if (goals && goals.length > 0) {
                        renderGoalOptions(goals);
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

    // 加載次目標（排除主目標）
    function loadSecondaryGoals(primaryId) {
        $.ajax({
            url: `${apiBaseUrl}/training-goals`,
            method: 'GET',
            headers: { 'X-WP-Nonce': nonce },
            success: function(goals) {
                const secondary = goals.filter(g => g.id != primaryId);
                const $secondary = $('#secondary-goals');
                $secondary.empty();

                if (secondary.length === 0) {
                    $secondary.html('<p>无可选的次要目标</p>');
                    return;
                }

                secondary.forEach(goal => {
                    $secondary.append(`
                        <label class="option-card goal-option">
                            <input type="radio" name="secondary_goal" value="${goal.id}">
                            <div class="option-content">
                                <h4>${goal.name}</h4>
                            </div>
                        </label>
                    `);
                });
            }
        });
    }

    // 渲染主要目標選項
    function renderGoalOptions(goals) {
        const $container = $('#primary-goals');
        $container.empty();

        goals.forEach(goal => {
            $container.append(`
                <label class="option-card goal-option">
                    <input type="radio" name="primary_goal" value="${goal.id}" required>
                    <div class="option-content">
                        <h4>${goal.name}</h4>
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
