<?php

namespace ClementPatigny\Model;

class Post {
    private $_id;
    private $_title;
    private $_content;
    private $_creationDate;

    /**
     * Post constructor.
     * @param array $postFeatures
     */
    public function __construct(array $postFeatures) {
        $this->hydrate($postFeatures);
    }

    /**
     * @param array $postFeatures
     */
    public function hydrate($postFeatures) {
        foreach($postFeatures as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = (int) $id;
    }


    /**
     * @param string $creationDate
     */
    public function setCreationDate($creationDate) {
        $this->_creationDate = new \datetime($creationDate);
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->_content;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @return object DateTime
     */
    public function getCreationDate() {
        return $this->_creationDate;
    }
}
