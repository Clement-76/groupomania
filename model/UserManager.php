<?php

namespace ClementPatigny\Model;

class UserManager extends Manager {
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
}
