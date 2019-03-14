<?php

namespace ClementPatigny\Controller;

use ClementPatigny\Model\CategoryManager;

class CategoriesController extends AppController {

    /**
     * echo the categories in JSON
     * @throws \Exception
     */
    public function getJSONCategories() {
        if (isset($_SESSION['user'])) {
            try {
                $categoryManager = new CategoryManager();
                $categories = $categoryManager->getCategories();
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }

            echo json_encode([
                'status' => 'success',
                'categories' => $categories
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'You\'re not connected'
            ]);
        }
    }
}
