<?php

namespace ClementPatigny\Controller;

use ClementPatigny\Model;

class UsersController extends AppController {

    public function login() {
        if (!isset($_SESSION['user'])) {
            $errors = false;

            if (isset($_POST['login']) && isset($_POST['password'])) {
                if (preg_match('#^[a-z\d]+([.\-_]{1}[a-z\d]+)*@[a-z]+\.[a-z]+$#', $_POST['login'])) {
                    $login = 'email';
                } else {
                    $login = 'pseudo';
                }

                $userManager = new UserManager();
                $user = $userManager->getUser($_POST['login'], $login);

                if (password_verify($_POST['password'], $user->getPassword())) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?action='); // redirection to home
                } else {
                    $errors = true;
                }
            }

            $pageTitle = "Connexion ou inscription";
            $this->twig->render('login_register.twig', compact('pageTitle', 'errors'));
        } else {
            header('Location: index.php?action='); // redirection to home
        }
    }
}