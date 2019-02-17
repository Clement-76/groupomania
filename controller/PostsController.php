<?php

namespace ClementPatigny\Controller;

class PostsController extends AppController {
    public function listPosts() {
        if (isset($_SESSION['user'])) {
            echo $this->twig->render('home.twig');
        } else {
            header('Location: index.php');
            exit();
        }
    }
}