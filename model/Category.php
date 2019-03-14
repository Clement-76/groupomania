<?php

namespace ClementPatigny\Model;

class Category implements \JsonSerializable {

    private $_id;
    private $_name;

    /**
     * Category constructor.
     * @param array $categoryFeatures
     */
    public function __construct(array $categoryFeatures) {
        $this->hydrate($categoryFeatures);
    }

    /**
     * @param $categoryFeatures
     */
    public function hydrate($categoryFeatures) {
        foreach($categoryFeatures as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    public function jsonSerialize() {
        return [
            'id' => $this->_id,
            'name' => $this->_name
        ];
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->_id = (int) $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->_name = $name;
    }
}
