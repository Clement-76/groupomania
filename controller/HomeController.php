<?php

namespace ClementPatigny\Controller;

class HomeController extends AppController {

    /**
     * display the home page
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function displayHome() {
        if (isset($_SESSION['user'])) {
            $pageTitle = "Groupomania";

            echo $this->twig->render('home.twig', compact('pageTitle', 'posts'));
        } else {
            header('Location: index.php');
            exit();
        }
    }
}
