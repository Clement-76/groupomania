<?php

namespace ClementPatigny\Model;

class PostManager extends Manager {
    /**
     * return an array that contains Post objects
     * @param int $offset
     * @param int $limit
     * @return Post[] array of Post objects
     * @throws \Exception
     */
    public function getPosts($limit = 10, $offset = 0) {
        $db = $this->connectDb();

        try {
            $q = $db->prepare("SELECT * FROM groupomania_posts ORDER BY creation_date DESC LIMIT :limit OFFSET :offset");

            $q->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $q->bindValue(':offset', $offset, \PDO::PARAM_INT);

            $q->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $posts = [];

        while ($post = $q->fetch()) {
            $postFeatures = [
                'content' => $post['content'],
                'title' => $post['title'],
                'id' => $post['id'],
                'creationDate' => $post['creation_date']
            ];

            $posts[] = new Post($postFeatures);
        }

        return $posts;
    }
}
