<?php

namespace ClementPatigny\Model;

class Post {
    private $_id;
    private $_title;
    private $_content;
    private $_creationDate;
    private $_elapsedTime;
    private $_author;
    private $_nbComments;
    private $_category;

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
        $this->_creationDate = new \datetime($creationDate, new \DateTimeZone("Europe/Paris"));
        $this->setElapsedTime($this->_creationDate);
    }

    /**
     * @param object $creationDate DateTime object
     */
    public function setElapsedTime($creationDate) {
        date_default_timezone_set('Europe/Paris'); // for strftime()
        $currentDate = new \DateTime(null, new \DateTimeZone("Europe/Paris"));
        $elapsedTime = $creationDate->diff($currentDate);

        switch (true) {
            case ($elapsedTime->format('%m') > 0):
                setlocale(LC_TIME,'fra');
                $elapsedTime = utf8_encode(strftime("%d %B %Y", $creationDate->getTimestamp()));
                break;

            case ($elapsedTime->format('%d') > 0):
                setlocale(LC_TIME, 'fra');
                $elapsedTime = utf8_encode(strftime("%#d %B, %Hh%M", $creationDate->getTimestamp()));
                break;

            case ($elapsedTime->format('%h') > 0):
                $elapsedTime = $elapsedTime->format('%hh');
                break;

            case ($elapsedTime->format('%i') > 0):
                $elapsedTime = $elapsedTime->format('%i min');
                break;

            case ($elapsedTime->format('%s') > 0):
                $elapsedTime = $elapsedTime->format('%ss');
                break;
        }

        $this->_elapsedTime = $elapsedTime;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author) {
        if (is_string($author)) {
            $this->_author = $author;
        }
    }

    /**
     * @param int $nbComments
     */
    public function setNbComments($nbComments) {
        $this->_nbComments = (int) $nbComments;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category) {
        if (is_string($category) && !empty($category)) {
            $this->_category = $category;
        } else {
            $this->_category = false;
        }
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

    /**
     * @return object DateTime
     */
    public function getElapsedTime() {
        return $this->_elapsedTime;
    }

    /**
     * @return string
     */
    public function getAuthor() {
        return $this->_author;
    }

    /**
     * @return int
     */
    public function getNbComments() {
        return $this->_nbComments;
    }

    /**
     * @return mixed
     */
    public function getCategory() {
        return $this->_category;
    }
}
