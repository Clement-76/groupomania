<?php

namespace ClementPatigny\Model;

class UserManager extends Manager {
    /**
     * get the user in the db with his email or password
     * @param $login the email or pseudo
     * @param $loginType the type of the login, 'email' or 'pseudo'
     * @return array a User object and the password of the user
     * @throws \Exception
     */
    public function getUser($login, $loginType) {
        $db = $this->connectDb();

        try {
            if ($loginType == 'email') {
                $q = $db->prepare('SELECT * FROM users WHERE email = ?');
            } else {
                $q = $db->prepare('SELECT * FROM users WHERE pseudo = ?');
            }

            $q->execute([$login]);
            $user = $q->fetch();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $userFeatures = [
            'id' => $user['id'],
            'pseudo' => $user['pseudo'],
            'email' => $user['email'],
            'role' => $user['role'],
            'registrationDate' => $user['registration_date'],
        ];

        $userObj = new User($userFeatures);
        return [
            'password' => $user['password'],
            'userObj' => $userObj
        ];
    }

    /**
     * add a new user to the db
     * @param $userFeatures
     * @throws \Exception
     */
    public function createUser($userFeatures) {
        $db = $this->connectDb();

        try {
            $q = $db->prepare('INSERT INTO users(pseudo, email, password) VALUE(:pseudo, :email, :password)');

            $q->bindValue(':pseudo', $userFeatures['pseudo'], \PDO::PARAM_STR);
            $q->bindValue(':email', $userFeatures['email'], \PDO::PARAM_STR);
            $q->bindValue(':password', $userFeatures['password'], \PDO::PARAM_STR);

            $q->execute();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $pseudo
     * @return string
     * @throws \Exception
     */
    public function getPseudo($pseudo) {
        $db = $this->connectDb();

        try {
            $q = $db->prepare('SELECT pseudo FROM users WHERE pseudo = ?');
            $q->execute([$pseudo]);
            $pseudo = $q->fetch()['pseudo'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $pseudo;
    }

    /**
     * @param string $email
     * @return string
     * @throws \Exception
     */
    public function getEmail($email) {
        $db = $this->connectDb();

        try {
            $q = $db->prepare('SELECT email FROM users WHERE email = ?');
            $q->execute([$email]);
            $email = $q->fetch()['email'];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $email;
    }
}
