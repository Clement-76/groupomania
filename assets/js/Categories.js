class Categories {
    constructor(categoriesContainerClass) {
        this.categoriesContainer = $('#' + categoriesContainerClass);
        this.getCategories();
    }

    /**
     * retrieves the categories with ajax request and displays it
     */
    getCategories() {
        $.get('index.php?action=categories.getJSONCategories', (data) => {
            if (data['status'] === 'success') {
                data['categories'].forEach(category => {
                    this.displayCategory(category);
                });
            } else {
                console.error(data['message']);
            }
        }, 'json');
    }

    /**
     * display the category pass as parameter in the categories container
     */
    displayCategory(category) {
        let url = 'index.php?action=posts.getJSONPosts&categoryId=' + category.id;
        let divCategory = create('a', {class: 'category', href: url});

        create('i', {class: 'icon-burn'}, divCategory);
        create('span', {class: 'category-name', text: category.name}, divCategory);

        this.categoriesContainer.append(divCategory);
    }
}
