<?php

class BackProductView extends View {

    public function show() {
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();

        ob_start();
        ?>
        <!-- Dashboard Header -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 font-chillax">Gestion des produits</h1>
                    <p class="text-gray-500 mt-1">Administration du catalogue et des stocks</p>
                </div>
                <label for="add-product-modal" class="btn btn-primary gap-2 mt-4 md:mt-0 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau produit
                </label>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary/10 text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total produits</p>
                        <h3 class="text-xl font-bold"><?= count($products) ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Stock total</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $totalStock = 0;
                                foreach ($products as $product) {
                                    $totalStock += $product->getStock();
                                }
                                echo $totalStock;
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Valeur moyenne</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $totalValue = 0;
                                foreach ($products as $product) {
                                    $totalValue += $product->getPrice();
                                }
                                echo count($products) > 0 ? number_format($totalValue / count($products), 2) . " €" : "0.00 €";
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des produits -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Liste des produits</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">ID</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Image</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Nom</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Description</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Prix</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Stock</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): 
                        $productModel = new ProductModel();
                        $firstImage = $product->getFirstImage();
                        // Correction de l'erreur - Vérification explicite que l'image n'est pas null
                        $imageSrc = $firstImage !== null ? htmlspecialchars($firstImage, ENT_QUOTES, 'UTF-8') : '';
                        ?>
                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3"><?= htmlspecialchars($product->getProductId()) ?></td>
                            <td class="px-4 py-3">
                                <?php if (!empty($imageSrc)): ?>
                                    <img class="h-16 w-16 object-cover rounded" src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($product->getProduct()) ?>">
                                <?php else: ?>
                                    <div class="h-16 w-16 bg-gray-200 flex items-center justify-center rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($product->getProduct()) ?></div>
                                <div class="text-xs text-gray-500">ID: <?= htmlspecialchars($product->getProductId()) ?></div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <div class="line-clamp-2 text-sm">
                                    <?= htmlspecialchars($product->getDescription()) ?>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-medium text-primary"><?= htmlspecialchars($product->getPrice()) ?> €</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full <?= $product->getStock() > 10 ? 'bg-green-100 text-green-600' : ($product->getStock() > 0 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') ?>">
                                    <?= htmlspecialchars($product->getStock()) ?> unités
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="/admin/products/edit/<?= $product->getProductId() ?>" 
                                       class="btn btn-sm btn-outline text-blue-600 border-blue-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button class="btn btn-sm btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white group"
                                            data-product-id="<?= $product->getProductId() ?>"
                                            onclick="confirmDelete(<?= $product->getProductId() ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modals -->
        <?php $this->renderAddModal(); ?>
        <?php $this->renderEditModal(); ?>
        <?php $this->renderDeleteModal(); ?>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Gestion des Produits', "Ceci est la page de gestion des produits.", ['backoffice', 'adminProducts']))->show();
    }

    private function renderAddModal() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        ?>
        <input type="checkbox" id="add-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Nouveau produit</h3>
                <form id="productForm" method="POST" action="/admin/products/create" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom du produit
                            </label>
                            <input type="text" name="product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prix
                            </label>
                            <input type="number" name="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" step="0.01" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Stock
                            </label>
                            <input type="number" name="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie
                            </label>
                            <select name="categoryId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <option value="">Aucune</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <textarea name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" rows="4" required></textarea>
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Images
                            </label>
                            <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <input type="file" class="hidden" name="images[]" id="add-images" multiple required>
                                        <label for="add-images" class="cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary">
                                            <span>Sélectionner des fichiers</span>
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <label for="add-product-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Créer le produit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    private function renderEditModal() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        ?>
        <input type="checkbox" id="edit-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Modifier le produit</h3>
                <form method="POST" id="edit-product-form" action="/admin/products/update" enctype="multipart/form-data">
                    <input type="hidden" name="productId" id="edit-product-id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom du produit
                            </label>
                            <input type="text" name="product" id="edit-product" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prix
                            </label>
                            <input type="number" name="price" id="edit-price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" step="0.01" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Stock
                            </label>
                            <input type="number" name="stock" id="edit-stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie
                            </label>
                            <select name="categoryId" id="edit-category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <option value="">Aucune</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <textarea name="description" id="edit-description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" rows="4" required></textarea>
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Images actuelles
                            </label>
                            <div id="edit-image-container" class="flex flex-wrap gap-4 p-4 border border-gray-200 rounded-md">
                                <!-- Les images existantes seront ajoutées ici -->
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Ajouter de nouvelles images
                                </label>
                                <input type="file" name="images[]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <label for="edit-product-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }


    private function renderDeleteModal() {
        ?>
        <input type="checkbox" id="delete-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box bg-white">
                <div class="flex items-center justify-center mb-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center">Confirmer la suppression</h3>
                <p class="py-4 text-gray-600 text-center">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement ce produit ?</p>
                <form method="POST" action="/admin/products/delete" id="delete-form">
                    <input type="hidden" name="productId" id="delete-product-id">
                    <div class="flex justify-center space-x-3 mt-4">
                        <label for="delete-product-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white border-none btn-sm px-6">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
