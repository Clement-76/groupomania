class PostsManager {
    constructor(inputSearchId, postsBlockId) {
        this.postsBlockId = $('#' + postsBlockId);
        this.inputSearch = $('#' + inputSearchId);
        this.inputSearch.on('input blur', this.getPosts.bind(this));
        this.getPosts();
    }

    /**
     * get the posts with an ajax request
     */
    getPosts() {
        let searchedText = this.inputSearch.val();
        let emptyRegex = /^[\s]*$/;
        let url;

        if (emptyRegex.test(searchedText)) {
            url = 'index.php?action=posts.getJSONPosts';
        } else {
            url = `index.php?action=posts.getJSONPosts&text=${searchedText}`;
        }

        $.get(url, (data) => {
            if (data['status'] === 'success') {
                // clear the posts
                this.postsBlockId.empty();

                data['posts'].forEach((post) => {
                    this.postsBlockId.append(this.createHTMLPost(post));
                });
            } else {
                console.error(data['message']);
            }
        }, 'json');
    }

    /**
     * creates and returns a post
     * @param post
     * @returns {HTMLElement}
     */
    createHTMLPost(post) {
        try {
            let article = create('article', {class: 'post'});

            let divTop = create('div', {class: 'top'}, article);
            create('div', {class: ['fa', 'fa-user-circle']}, divTop);
            let pAuthor = create('p', {}, divTop);
            create('b', {class: 'author', text: post.author}, pAuthor);
            create('br', {}, pAuthor);
            create('span', {class: 'time', text: post.elapsedTime}, pAuthor);
            create('div', {class: 'three-dots'}, divTop);

            create('h2', {text: post.title}, article);
            create('div', {class: 'content', text: post.content}, article);

            let pNbComments = create('p', {class: 'nb-comments'}, article);
            create('i', {class: ['far', 'fa-comment']}, pNbComments);
            // if the number of comments is more than 0, add "s" to the word
            create('span', {text: '0 Commentaire'}, pNbComments);

            return article;
        } catch (e) {
            throw new Error(e);
        }
    }
}
