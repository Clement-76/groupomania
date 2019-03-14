<?php

namespace ClementPatigny\Controller;

use ClementPatigny\Model\PostManager;

class PostsController extends AppController {
    /**
     * return the posts in JSON
     * @throws \Exception
     */
    public function getJSONPosts() {
        if (isset($_SESSION['user'])) {

            if (isset($_GET['text']) && !empty($_GET['text'])) {
                try {
                    $postManager = new PostManager();
                    $posts = $postManager->getPosts($_GET['text']);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }

                echo json_encode([
                    'status' => 'success',
                    'posts' => $posts
                ]);
            } else {
                try {
                    $postManager = new PostManager();
                    $posts = $postManager->getPosts();
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }

                echo json_encode([
                    'status' => 'success',
                    'posts' => $posts
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'You\'re not connected'
            ]);
        }
    }
}