class PostsManager {
    constructor(inputSearchId, postsBlockId) {
        this.postsBlockId = $('#' + postsBlockId);
        this.inputSearch = $('#' + inputSearchId);
        this.inputSearch.on('keypress', this.enterDetection.bind(this));
        this.inputSearch.on('blur', this.getPosts.bind(this));
        this.getPosts();
    }

    /**
     * send a new message if the enter key is pressed but not the shift key
     * @param e the event object
     */
    enterDetection(e) {
        if (e.keyCode === 13) {
            if (!e.shiftKey) {
                this.getPosts();
            }
        }
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
            // if there are posts that contains the searched text
            if (data['posts'].length > 0) {
                let postsHTML = [];

                data['posts'].forEach((post) => {
                    postsHTML.push(this.createHTMLPost(post));
                });

                this.displayPosts(postsHTML);
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

    /**
     * display the post on the home page
     * @param posts
     */
    displayPosts(posts) {
        this.postsBlockId.empty();

        posts.forEach((post) => {
            this.postsBlockId.append(post);
        });
    }
}
