
document.addEventListener('DOMContentLoaded', function () {
  // 首頁 banner 輪播初始化
  if (document.querySelector('.banner-swiper')) {
    new Swiper('.banner-swiper', {
        loop: true,
        speed: 1500, // 動畫時間 1500ms = 1.5 秒
        effect: 'fade',
        fadeEffect: {
        crossFade: true, // 淡出與淡入同時進行，更柔和
        },
        autoplay: {
            delay: 5000, // 每 5000 毫秒（5 秒）切換一次
            disableOnInteraction: false, // 使用者互動後仍繼續自動播放
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
  }

  // 教練證照輪播初始化
    if (document.querySelector('.coach-cert-swiper')) {
        new Swiper('.coach-cert-swiper', {
        loop: false,
        speed: 800,
        spaceBetween: 16,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.cert-next',
            prevEl: '.cert-prev',
        },
        breakpoints: {
            0: {
            slidesPerView: 1,
            },
            768: {
            slidesPerView: 1,
            },
            1024: {
            slidesPerView: 1,
            }
        },
    });
    }

});
