(function() {
    const siteNavigations = document.querySelectorAll('#site-navigation, .footer-sitemap');

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
})();