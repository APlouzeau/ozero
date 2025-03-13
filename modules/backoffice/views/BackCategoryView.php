<?php

class BackCategoryView extends View {

    public function show() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        ob_start();
        ?>
        <!-- Dashboard Header -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 font-chillax">Gestion des catégories</h1>
                    <p class="text-gray-500 mt-1">Administration des catégories de produits</p>
                </div>
                <label for="add-category-modal" class="btn btn-primary gap-2 mt-4 md:mt-0 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle catégorie
                </label>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary/10 text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total catégories</p>
                        <h3 class="text-xl font-bold"><?= count($categories) ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Catégories principales</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $mainCategories = count(array_filter($categories, function($category) { 
                                    return $category->getParentCategoryId() === null || $category->getParentCategoryId() === 0; 
                                }));
                                echo $mainCategories;
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Sous-catégories</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $subCategories = count(array_filter($categories, function($category) { 
                                    return $category->getParentCategoryId() !== null && $category->getParentCategoryId() !== 0; 
                                }));
                                echo $subCategories;
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des catégories -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Liste des catégories</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">ID</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Nom</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Catégorie parente</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($categories as $category): 
                        $categoryModel = new CategoryModel(); 
                        $parentCategory = $category->getParentCategoryId() ? $categoryModel->getCategoryById($category->getParentCategoryId()) : null;
                        ?>
                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3"><?= htmlspecialchars($category->getCategoryId()) ?></td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($category->getName()) ?></div>
                            </td>
                            <td class="px-4 py-3">
                                <?php if ($parentCategory): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                                        <?= htmlspecialchars($parentCategory->getName()) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Catégorie principale</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button type="button"
                                           class="btn btn-sm btn-outline text-blue-600 border-blue-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white group edit-category-btn"
                                           data-category-id="<?= $category->getCategoryId() ?>"
                                           data-name="<?= htmlspecialchars($category->getName()) ?>"
                                           data-parent-category-id="<?= $category->getParentCategoryId() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white group delete-category-btn"
                                            data-category-id="<?= $category->getCategoryId() ?>">
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

        <!-- Script JavaScript pour gérer les modals -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sélection des modals complets (pas juste les checkboxes)
                const editModalCheckbox = document.getElementById('edit-category-modal');
                const deleteModalCheckbox = document.getElementById('delete-category-modal');
                
                // Sélection des éléments modals complets
                const editModalElement = editModalCheckbox.nextElementSibling;
                const deleteModalElement = deleteModalCheckbox.nextElementSibling;
                
                // Sélection des éléments de formulaire
                const editCategoryId = document.getElementById('edit-category-id');
                const editName = document.getElementById('edit-name');
                const editParentCategoryId = document.getElementById('edit-parent-category-id');
                const deleteCategoryId = document.getElementById('delete-category-id');
                
                // Sélection des boutons
                const editButtons = document.querySelectorAll('.edit-category-btn');
                const deleteButtons = document.querySelectorAll('.delete-category-btn');
                const closeEditModalButtons = document.querySelectorAll('.close-edit-modal');
                const closeDeleteModalButtons = document.querySelectorAll('.close-delete-modal');
                
                // Fonction pour masquer tous les modals
                function hideAllModals() {
                    // Désélectionner les checkboxes
                    editModalCheckbox.checked = false;
                    deleteModalCheckbox.checked = false;
                    
                    // Cacher les modals via CSS
                    editModalElement.style.opacity = '0';
                    editModalElement.style.pointerEvents = 'none';
                    deleteModalElement.style.opacity = '0';
                    deleteModalElement.style.pointerEvents = 'none';
                }
                
                // Fonction pour afficher le modal d'édition
                function showEditModal() {
                    hideAllModals();
                    setTimeout(() => {
                        editModalCheckbox.checked = true;
                        editModalElement.style.opacity = '1';
                        editModalElement.style.pointerEvents = 'auto';
                    }, 100);
                }
                
                // Fonction pour afficher le modal de suppression
                function showDeleteModal() {
                    hideAllModals();
                    setTimeout(() => {
                        deleteModalCheckbox.checked = true;
                        deleteModalElement.style.opacity = '1';
                        deleteModalElement.style.pointerEvents = 'auto';
                    }, 100);
                }
                
                // Fonction pour gérer le clic sur bouton d'édition
                function handleEditClick(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Récupérer les données
                    const categoryId = this.getAttribute('data-category-id');
                    const name = this.getAttribute('data-name');
                    const parentCategoryId = this.getAttribute('data-parent-category-id');
                    
                    // Remplir les champs du formulaire
                    editCategoryId.value = categoryId;
                    editName.value = name;
                    editParentCategoryId.value = parentCategoryId || '';
                    
                    // Afficher le modal d'édition
                    showEditModal();
                    
                    console.log('Bouton Éditer cliqué pour catégorie ID:', categoryId);
                }
                
                // Fonction pour gérer le clic sur bouton de suppression
                function handleDeleteClick(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Récupérer l'ID
                    const categoryId = this.getAttribute('data-category-id');
                    deleteCategoryId.value = categoryId;
                    
                    // Afficher le modal de suppression
                    showDeleteModal();
                    
                    console.log('Bouton Supprimer cliqué pour catégorie ID:', categoryId);
                }
                
                // Nettoyage des événements existants
                editButtons.forEach(button => {
                    const clone = button.cloneNode(true);
                    button.parentNode.replaceChild(clone, button);
                });
                
                deleteButtons.forEach(button => {
                    const clone = button.cloneNode(true);
                    button.parentNode.replaceChild(clone, button);
                });
                
                // Ajout des nouveaux écouteurs d'événements
                document.querySelectorAll('.edit-category-btn').forEach(button => {
                    button.addEventListener('click', handleEditClick);
                });
                
                document.querySelectorAll('.delete-category-btn').forEach(button => {
                    button.addEventListener('click', handleDeleteClick);
                });
                
                // Fermeture des modals
                closeEditModalButtons.forEach(button => {
                    button.addEventListener('click', hideAllModals);
                });
                
                closeDeleteModalButtons.forEach(button => {
                    button.addEventListener('click', hideAllModals);
                });
                
                // Initialiser les modals comme fermés
                hideAllModals();
                
                // Empêcher les clics sur les modals de se propager aux boutons
                editModalElement.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                deleteModalElement.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                console.log('Script de gestion des modals initialisé');
            });
        </script>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Gestion des Catégories', "Ceci est la page de gestion des catégories.", ['backoffice','category', 'deleteCategory']))->show();
    }

    private function renderAddModal() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        ?>
        <input type="checkbox" id="add-category-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Nouvelle catégorie</h3>
                <form id="category-form" method="POST" action="/admin/categories/create" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de la catégorie
                            </label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie parente
                            </label>
                            <select name="parentCategoryId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <option value="">Aucune (catégorie principale)</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <label for="add-category-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Créer la catégorie</button>
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
        <input type="checkbox" id="edit-category-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-white">
                <h3 class="text-2xl font-bold text-primary mb-6">Modifier la catégorie</h3>
                <form id="edit-category-form" method="POST" action="/admin/categories/update">
                    <input type="hidden" name="categoryId" id="edit-category-id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de la catégorie
                            </label>
                            <input type="text" name="name" id="edit-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition" required>
                        </div>

                        <div class="form-control">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie parente
                            </label>
                            <select name="parentCategoryId" id="edit-parent-category-id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition">
                                <option value="">Aucune (catégorie principale)</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <button type="button" class="btn btn-outline btn-sm px-6 close-edit-modal">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-sm px-6">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    private function renderDeleteModal() {
        ?>
        <input type="checkbox" id="delete-category-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box bg-white">
                <div class="flex items-center justify-center mb-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center">Confirmer la suppression</h3>
                <p class="py-4 text-gray-600 text-center">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement cette catégorie ?</p>
                <form method="POST" action="/admin/categories/delete" id="delete-form">
                    <input type="hidden" name="categoryId" id="delete-category-id">
                    <div class="flex justify-center space-x-3 mt-4">
                        <button type="button" class="btn btn-outline btn-sm px-6 close-delete-modal">Annuler</button>
                        <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white border-none btn-sm px-6">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
