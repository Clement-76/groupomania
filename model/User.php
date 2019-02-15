<?php

namespace ClementPatigny\Model;

class User {
    private $_id;
    private $_pseudo;
    private $_email;
    private $_role;
    private $_registrationDate;

    /**
     * User constructor.
     * @param array $userFeatures
     */
    public function __construct(array $userFeatures) {
        $this->hydrate($userFeatures);
    }

    public function hydrate($userFeatures) {
        foreach ($userFeatures as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = (int)$id;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo) {
        if (is_string($pseudo)) {
            $this->_pseudo = $pseudo;
        }
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    /**
     * @param string $role
     */
    public function setRole($role) {
        if (is_string($role)) {
            $this->_role = $role;
        }
    }

    /**
     * @param string $registrationDate
     */
    public function setRegistrationDate($registrationDate) {
        $this->_registrationDate = new \DateTime($registrationDate);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getPseudo() {
        return $this->_pseudo;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getRole() {
        return $this->_role;
    }

    /**
     * @return object DateTime
     */
    public function getRegistrationDate() {
        return $this->_registrationDate;
    }

}