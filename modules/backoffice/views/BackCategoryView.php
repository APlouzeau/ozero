<?php

class BackCategoryView extends View {

    public function show() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        ob_start();
        ?>
        <!-- Main Content -->
        <div class="flex flex-col gap-4 justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Gestion des catégories</h1>
            <label for="add-category-modal" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter une catégorie
            </label>
        </div>

        <!-- Tableau des catégories -->
        <div class="overflow-x-auto rounded-lg border border-base-200">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Nom</th>
                    <th class="text-sm font-bold">Catégorie parente</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): 
                    $categoryModel = new CategoryModel(); ?>
                    <tr>
                        <td><?= htmlspecialchars($category->getCategoryId()) ?></td>
                        <td><?= htmlspecialchars($category->getName()) ?></td>
                        <td><?= $category->getParentCategoryId() ? htmlspecialchars($categoryModel->getCategoryById($category->getParentCategoryId())->getName()) : 'Aucune' ?></td>
                        <td class="flex gap-2">
                            <label for="edit-category-modal"
                                   class="btn btn-sm btn-info"
                                   data-category-id="<?= $category->getCategoryId() ?>"
                                   data-name="<?= htmlspecialchars($category->getName()) ?>"
                                   data-parent-category-id="<?= $category->getParentCategoryId() ?>">
                                Modifier
                            </label>

                            <button class="btn btn-sm btn-error"
                                    data-category-id="<?= $category->getCategoryId() ?>">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modals -->
        <?php $this->renderAddModal(); ?>
        <?php $this->renderEditModal(); ?>
        <?php $this->renderDeleteModal(); ?>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Gestion des Catégories', "Ceci est la page de gestion des catégories.", ['backoffice','category']))->show();
    }

    private function renderAddModal() {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        ?>
        <input type="checkbox" id="add-category-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Nouvelle catégorie</h3>
                <form id="category-form" method="POST" action="/admin/categories/create" enctype="multipart/form-data">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom de la catégorie</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Catégorie parente</span>
                        </label>
                        <select name="parentCategoryId" class="select select-bordered w-full">
                            <option value="">Aucune</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Créer la catégorie</button>
                        <label for="add-category-modal" class="btn">Annuler</label>
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
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Modifier la catégorie</h3>
                <form id="edit-category-form" method="POST" action="/admin/categories/update">
                    <input type="hidden" name="categoryId" id="edit-category-id">

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom de la catégorie</span>
                        </label>
                        <input type="text" name="name" id="edit-name" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Catégorie parente</span>
                        </label>
                        <select name="parentCategoryId" id="edit-parent-category-id" class="select select-bordered w-full">
                            <option value="">Aucune</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getCategoryId() ?>"><?= htmlspecialchars($category->getName()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <label for="edit-category-modal" class="btn">Annuler</label>
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
            <div class="modal-box">
                <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                <p class="py-4">Êtes-vous sûr de vouloir supprimer définitivement cette catégorie ?</p>
                <form method="POST" action="/admin/categories/delete" id="delete-form">
                    <input type="hidden" name="categoryId" id="delete-category-id">
                    <div class="modal-action">
                        <button type="submit" class="btn btn-error">Supprimer</button>
                        <label for="delete-category-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }}
?>
