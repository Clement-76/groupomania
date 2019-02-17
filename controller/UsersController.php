<?php

namespace ClementPatigny\Controller;

use ClementPatigny\Model\UserManager;

class UsersController extends AppController {

    public function login() {
        if (!isset($_SESSION['user'])) {
            $errors = false;

            if (isset($_POST['login']) && isset($_POST['password'])) {
                if (preg_match('#^[a-z\d]+([.\-_]{1}[a-z\d]+)*@[a-z\d]+\.[a-z]+$#', $_POST['login'])) {
                    $login = 'email';
                } else {
                    $login = 'pseudo';
                }

                try {
                    $userManager = new UserManager();
                    $user = $userManager->getUser($_POST['login'], $login);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }

                if (password_verify($_POST['password'], $user->getPassword())) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?action='); // redirection to home
                } else {
                    $errors = true;
                }
            }

            $pageTitle = "Connexion";
            echo $this->twig->render('login.twig', compact('errors', 'pageTitle'));
        } else {
            header('Location: index.php?action='); // redirection to home
        }
    }

    /**
     * displays the form to register and if the form
     * has been submitted checks the data and creates a new user
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function register() {
        if (!isset($_SESSION['user'])) {
            $errors['errors'] = false;

            if (isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {

                if (!preg_match('#^[a-z\d]+([.\-_]{1}[a-z\d]+)*@[a-z\d]+\.[a-z]+$#', $_POST['email'])) {
                    $errors['email'] = true;
                    $errors['errors'] = true;
                }

                try {
                    $userManager = new UserManager();
                    $pseudo = $userManager->getPseudo($_POST['pseudo']);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }

                if ($_POST['pseudo'] == $pseudo) {
                    $errors['pseudo_not_available'] = true;
                    $errors['errors'] = true;
                }

                if (!preg_match('#^[a-zA-Z\d\_\-.]{0,25}$#', $_POST['pseudo'])) {
                    $errors['pseudo'] = true;
                    $errors['errors'] = true;
                }

                $lowercase = preg_match('#[a-z]#', $_POST['password']);
                $uppercase = preg_match('#[A-Z]#', $_POST['password']);
                $number = preg_match('#\d#', $_POST['password']);

                if (!$lowercase || !$uppercase || !$number || strlen($_POST['password']) < 7) {
                    $errors['password'] = true;
                    $errors['errors'] = true;
                }

                if ($_POST['password'] != $_POST['password_confirmation']) {
                    $errors['password_confirmation'] = true;
                    $errors['errors'] = true;
                }

                if (!$errors['errors']) {
                    $userData = [
                        'email' => $_POST['email'],
                        'pseudo' => $_POST['pseudo'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                    ];

                    try {
                        $userManager->createUser($userData);
                    } catch (\Exception $e) {
                        throw new \Exception($e->getMessage());
                    }

                    header('Location: index.php');
                }
            }

            $pageTitle = "Inscription";

            if (!$errors['errors']) {
                echo $this->twig->render('register.twig', compact('errors', 'pageTitle'));
            } else {
                $email = $_POST['email'];
                $pseudo = $_POST['pseudo'];
                echo $this->twig->render('register.twig', compact('errors', 'pageTitle', 'email', 'pseudo'));
            }
        } else {
            header('Location: index.php?action='); // redirection to home
        }
    }
}
