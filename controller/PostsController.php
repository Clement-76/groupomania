<?php

namespace ClementPatigny\Controller;

use ClementPatigny\Model\PostManager;

class PostsController extends AppController {

    /**
     * list all posts in the home page
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function listPosts() {
        if (isset($_SESSION['user'])) {
            try {
                $postManager = new PostManager();
                $posts = $postManager->getPosts();
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }

            $pageTitle = "Groupomania";

            echo $this->twig->render('home.twig', compact('pageTitle', 'posts'));
        } else {
            header('Location: index.php');
            exit();
        }
    }
}