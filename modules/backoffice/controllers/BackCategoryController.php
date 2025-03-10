<?php

class BackCategoryController {

    protected CategoryModel $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    /**
     * @return void
     */
    public function execute() {
        $view = new BackCategoryView();
        $view->show();
    }

    /**
     * @return void
     */
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['name'])) {
                Utils::sendResponse('error', 'Le nom de la catégorie est obligatoire.');
                return;
            }

            $name = $_POST['name'];
            if(isset($_POST['parentCategoryId']) && $_POST['parentCategoryId'] !== '' && $_POST['parentCategoryId'] !== null) {
                $parentCategoryId = (int) $_POST['parentCategoryId'];
            } else {
                $parentCategoryId = null;
            }

            // Ajout de la catégorie et récupération de son ID
            $categoryId = $this->categoryModel->addCategory($name, $parentCategoryId);
            if ($categoryId) {
                Utils::sendResponse('success', 'Catégorie ajoutée avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de l\'ajout de la catégorie.');
            }
        }
    }

    /**
     * @return void
     */
    public function updateCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['name'])) {
                Utils::sendResponse('error', 'Le nom de la catégorie est obligatoire.');
                return;
            }

            $categoryId = (int) $_POST['categoryId'] ?? null;
            $name = $_POST['name'];
            if(isset($_POST['parentCategoryId']) && $_POST['parentCategoryId'] !== '' && $_POST['parentCategoryId'] !== null) {
                $parentCategoryId = (int) $_POST['parentCategoryId'];
            } else {
                $parentCategoryId = null;
            }

            if (!$categoryId || !$name) {
                Utils::sendResponse('error', 'ID de la catégorie ou nom manquant.');
                return;
            }
        
            $updated = $this->categoryModel->updateCategory($categoryId, $name, $parentCategoryId);
            if ($updated) {
                Utils::sendResponse('success', 'Catégorie mise à jour avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de la mise à jour de la catégorie.');
            }
        }
    }

    /**
     * @return void
     */
    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $categoryId = $data['categoryId'];

            // Récupérer les images du produit avant la suppression
            // $productImages = $this->productModel->getProductImages($productId);

            // Supprimer les images du produit dans la base de données
            // $imagesDeleted = true;
            // foreach ($productImages as $imagePath) {
            //     $deleted = $this->productModel->deleteProductImage($productId, $imagePath);
            //     if (!$deleted) {
            //         $imagesDeleted = false;
            //         break;
            //     }
            // }

            // Supprimer les fichiers images physiques
            // if ($imagesDeleted) {
            //     foreach ($productImages as $imagePath) {
            //         $imagePathFull = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            //         if (file_exists($imagePathFull)) {
            //             unlink($imagePathFull);  // Supprimer le fichier image
            //         }
            //     }
            // }

            // Supprimer le produit de la base de données
            $deleted = $this->categoryModel->deleteCategory($categoryId);

            if ($deleted) {
                Utils::sendResponse('success', 'Catégorie supprimée avec succès.');
            } else {
                Utils::sendResponse('error', 'Erreur lors de la suppression de la catégorie.');
            }
        }
    }
}
