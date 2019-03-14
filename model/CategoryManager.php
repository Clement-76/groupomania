<?php

namespace ClementPatigny\Model;

class CategoryManager extends Manager {

    /**
     * @return Category[] array of Category objects
     * @throws \Exception
     */
    public function getCategories() {
        $db = $this->getDb();

        try {
            $q = $db->query('SELECT * FROM groupomania_categories');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $categories = [];

        while ($category = $q->fetch()) {
            $categoryFeatures = [
                'id' => $category['id'],
                'name' => $category['name']
            ];

            $categories[] = new Category($categoryFeatures);
        }

        return $categories;
    }
}
