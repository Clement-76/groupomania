class Menu {
    /**
     * Menu's constructor
     * @param overlayId the id of the overlay
     * @param categoriesId
     * @param hamburgerCategoriesId
     * @param hamburgerSearchId
     * @param searchIconId
     * @param searchId
     * @param iconsId the id of the container of icons
     */
    constructor(overlayId, categoriesId, hamburgerCategoriesId, hamburgerSearchId, searchIconId, searchId, iconsId) {
        this.categoriesStatus = 'close';
        this.categoriesContainer = $('#' + categoriesId);
        this.searchStatus = 'close';
        this.overlay = $('#' + overlayId);
        this.hamburgerCategories = $('#' + hamburgerCategoriesId);
        this.hamburgerSearch = $('#' + hamburgerSearchId);
        this.search = $('#' + searchId);
        this.searchIcon = $('#' + searchIconId);
        this.iconsContainer = $('#' + iconsId);

        this.hamburgerCategories.on('click', this.toggleMenu.bind(this));
        this.overlay.on('click', this.closeMenu.bind(this));
        this.searchIcon.on('click', this.openSearch.bind(this));
        this.hamburgerSearch.on('click', this.closeSearch.bind(this));
        $(window).on('resize', this.checkWindowWidth.bind(this));
    }

    /**
     * checks the width of the window to close or open the menu's elements
     */
    checkWindowWidth() {
        if ($(window).width() > 768) {
            if (this.searchStatus === 'open') this.closeSearch();
            if (this.categoriesStatus === 'open') this.closeMenu();
            this.categoriesContainer.css('transform', '');
        }
    }

    /**
     * shows the input to research posts
     */
    openSearch() {
        if (this.categoriesStatus === 'open') {
            this.closeMenu();
        }

        this.hamburgerSearch.show();

        this.search.show(0, () => {
            this.search.css('left', '0');
            this.search.css('opacity', '1');
        });

        this.search.find('input').focus();
        this.iconsContainer.hide();
        this.hamburgerCategories.hide();
        this.searchStatus = 'open';

    }

    /**
     * closes the input to research posts
     */
    closeSearch() {
        this.hamburgerSearch.hide();
        this.search.delay(500).hide(0);
        this.search.css('left', '300px');
        this.search.css('opacity', '0');
        this.iconsContainer.show();
        this.hamburgerCategories.show();
        this.searchStatus = 'close';
    }

    /**
     * toggles between close and open the menu
     */
    toggleMenu() {
        if (this.categoriesStatus === 'close') {
            this.openMenu();
        } else {
            this.closeMenu();
        }
    }

    /**
     * opens the menu of categories
     */
    openMenu() {
        this.overlay.addClass('open');
        this.hamburgerCategories.addClass('close');
        this.hamburgerCategories.removeClass('open');
        $('body').css('overflow', 'hidden');
        this.categoriesContainer.css('transform', 'translateX(0)');
        this.categoriesStatus = 'open';
    }

    /**
     * closes the menu of categories
     */
    closeMenu() {
        this.overlay.removeClass('open');
        this.hamburgerCategories.addClass('open');
        this.hamburgerCategories.removeClass('close');
        $('body').css('overflow', 'visible');
        this.categoriesContainer.css('transform', 'translateX(-120%)');
        this.categoriesStatus = 'close';
    }
}
