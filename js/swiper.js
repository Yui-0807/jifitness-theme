
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
        loop: true,
        speed: 800,
        spaceBetween: 16,
        slidesPerView: 1,
        autoplay: {
            delay: 20000, //5000ms = 5s 五秒
            disableOnInteraction: true, //使用者操作（例如點擊箭頭）後，停止自動播放，true ➜ 會停止（需要手動播放）
        },
        navigation: {
            nextEl: '.cert-next',
            prevEl: '.cert-prev',
        },
    });
    }

     // 新增 blog 文章輪播初始化
    if (document.querySelector('.blog-swiper')) {
        new Swiper('.blog-swiper', {
            loop: false,
            speed: 800,
            spaceBetween: 16,
            navigation: {
                nextEl: '.blog-next',
                prevEl: '.blog-prev',
              },
              breakpoints: {
                0: {
                slidesPerView: 1,
                },
                768: {
                slidesPerView: 2,
                },
                1280: {
                slidesPerView: 2.2,
                }
            },
        });
    }
    
        // Studio 環境介紹輪播（僅小螢幕使用）
    if (document.querySelector('.studio-swiper')) {
        new Swiper('.studio-swiper', {
            loop: true,
            speed: 800,
            spaceBetween: 16,
            slidesPerView: 'auto',
            centeredSlides: true,
            grabCursor: true,
            autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            },
        });
    }

});
