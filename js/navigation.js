(function() {
    const siteNavigations = document.querySelectorAll('#site-navigation, .menu-footer-sitemap-container');

    siteNavigations.forEach((siteNavigation) => {
        if (!siteNavigation) return;

        // 主菜單按鈕
        const mainButton = siteNavigation.querySelector('button.menu-toggle');
        const menu = siteNavigation.querySelector('ul');

        if (!menu) {
            if (mainButton) mainButton.style.display = 'none';
            return;
        }

        // 初始化菜單類
        if (!menu.classList.contains('nav-menu')) {
            menu.classList.add('nav-menu');
        }

        // 主菜單切換功能
        if (mainButton) {
            mainButton.addEventListener('click', function(e) {
                e.stopImmediatePropagation(); // 防止其他監聽器干擾
                
                // 切換兩種狀態類以確保兼容性
                siteNavigation.classList.toggle('toggled');
                menu.classList.toggle('active');
                
                // 同步 aria 狀態
                const wasExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !wasExpanded);
            });
        }

        // 子菜單處理
        const menuItemsWithChildren = menu.querySelectorAll(`
            li.menu-item-has-children,
            li.page_item_has_children
        `);

        menuItemsWithChildren.forEach((menuItem) => {
            if (menuItem.querySelector('.sub-menu-toggle')) return;

            const toggleButton = document.createElement('button');
            toggleButton.className = 'sub-menu-toggle';
            toggleButton.innerHTML = '<span class="toggle-icon"></span>';
            toggleButton.setAttribute('aria-expanded', 'false');
            
            toggleButton.addEventListener('click', function(e) {
                e.stopPropagation(); // 不阻止默認行為
                const subMenu = menuItem.querySelector('ul');
                if (!subMenu) return;
                
                const wasExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !wasExpanded);
                subMenu.classList.toggle('active');
            });
            
            menuItem.querySelector('a')?.insertAdjacentElement('afterend', toggleButton);
        });

        // 點擊外部關閉
        document.addEventListener('click', function(e) {
            if (!siteNavigation.contains(e.target)) {
                siteNavigation.classList.remove('toggled');
                if (menu) menu.classList.remove('active');
                if (mainButton) mainButton.setAttribute('aria-expanded', 'false');
                
                // 關閉所有子菜單
                siteNavigation.querySelectorAll('.sub-menu').forEach(subMenu => {
                    subMenu.classList.remove('active');
                });
                siteNavigation.querySelectorAll('.sub-menu-toggle').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                });
            }
        });
    });

    /**
	 * Scroll to top button links to header navigation 
	 */
	
	document.addEventListener('DOMContentLoaded', function () {
        // 滾動到上方
        const scrollTopButton = document.querySelector('#scroll-top');
        if (scrollTopButton) {
            scrollTopButton.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    
            window.addEventListener('scroll', function () {
                scrollTopButton.style.opacity = window.scrollY === 0 ? "0" : "1";
                scrollTopButton.style.pointerEvents = window.scrollY === 0 ? "none" : "auto";
            });
        }
    
        // Floating Button 隱藏在 footer
        const floatingBtn = document.querySelector('.toggle-btn');
        const footer = document.querySelector('.site-footer');
        if (floatingBtn && footer) {
            window.addEventListener('scroll', function () {
                const footerTop = footer.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                const nearFooter = footerTop < windowHeight;
    
                floatingBtn.style.opacity = nearFooter ? '0' : '1';
                floatingBtn.style.pointerEvents = nearFooter ? 'none' : 'auto';
            });
        }
    
        // Floating Menu 開關
        const toggleBtn = document.querySelector('.floating-btn .toggle-btn');
        const floatingMenu = document.querySelector('.floating-btn .floating-menu');
        const floatingBtnWrapper = document.querySelector('.floating-btn');

        if (toggleBtn && floatingMenu) {
            toggleBtn.addEventListener('click', function () {
                floatingMenu.classList.toggle('active');
                floatingBtnWrapper.classList.toggle('active');
            });
        }
    });
    
})();