<?php

namespace ClementPatigny\Model;

class PostManager extends Manager {

    /**
     * return an array that contains Post objects
     * @param bool $text = false per default
     * @return Post[] array of Post objects
     * @throws \Exception
     */
    public function getPosts($text = false) {
        $db = $this->connectDb();

        try {
            // if we search posts by title with a text provided by the user
            if ($text) {
                $q = $db->prepare(
                    "SELECT posts.id,
                    title,
                    content,
                    creation_date,
                    users.pseudo,
                    categories.name AS category
                    FROM groupomania_posts AS posts
                    LEFT JOIN groupomania_categories AS categories
                    ON posts.category_id = categories.id
                    INNER JOIN groupomania_users AS users
                    ON posts.user_id = users.id
                    WHERE title LIKE ?
                    ORDER BY posts.creation_date DESC"
                );
                $q->execute(['%' . $text . '%']);
            } else {
                $q = $db->query(
                    "SELECT posts.id,
                    title,
                    content,
                    creation_date,
                    users.pseudo,
                    categories.name AS category
                    FROM groupomania_posts AS posts
                    LEFT JOIN groupomania_categories AS categories
                    ON posts.category_id = categories.id
                    INNER JOIN groupomania_users AS users
                    ON posts.user_id = users.id
                    ORDER BY posts.creation_date DESC"
                );
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $posts = [];

        while ($post = $q->fetch()) {
            $postFeatures = [
                'content' => $post['content'],
                'title' => $post['title'],
                'id' => $post['id'],
                'creationDate' => $post['creation_date'],
                'category' => $post['category'],
                'author' => $post['pseudo']
            ];

            $posts[] = new Post($postFeatures);
        }

        return $posts;
    }
}
