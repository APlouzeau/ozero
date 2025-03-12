<?php

class BackCreateEditArticleView extends View
{
    /**
     * @var ArticleEntity|null
     * @var array|null
     */
    private ?ArticleEntity $article;
    private ?array $associatedProducts;
    private bool $doBlogExist;

    /**
     * Constructeur.
     *
     * @param ArticleEntity|null $article Si un article est fourni, la vue sera en mode édition. Sinon, en mode création.
     */
    public function __construct($article = null, $associatedProducts = [])
    {
        $this->article = $article;
        $this->associatedProducts = $associatedProducts;
        $articleModel = new ArticleModel();
        $this->doBlogExist = $articleModel->doBlogExist();
    }

    public function show(): void
    {
        $isEditing = $this->article !== null;
        $productModel = new ProductModel();
        ob_start();
?>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">
                <?= $isEditing ? 'Modifier l\'article' : 'Créer un nouvel article' ?>
            </h1>
            <div id="flashMessageContainer"></div>
            <form method="POST" action="<?= $isEditing ? ('/admin/articles/update/' . $this->article->getArticleId()) : '/admin/articles/create' ?>">
                <input type="hidden" name="doBlogExist" id="doBlogExist" value="<?= $this->doBlogExist ? 'true' : 'false' ?>">
                <?php if ($isEditing): ?>
                    <!-- Champ caché pour l'ID de l'article en cas d'édition -->
                    <input type="hidden" name="articleId" value="<?= htmlspecialchars($this->article->getArticleId()) ?>">
                <?php endif; ?>

                <!-- Titre -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="title">Titre</label>
                    <input type="text" name="title" id="title" class="input input-bordered w-full"
                        value="<?= $isEditing ? htmlspecialchars($this->article->getTitle()) : '' ?>"
                        required>
                </div>

                <!-- Type (Dropdown) -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="type">Type d'article</label>
                    <select name="type" id="type" class="select select-bordered w-full">
                        <option value="diy" id="diy" <?= ($isEditing && $this->article->getType() === 'diy') ? 'selected' : '' ?>>DIY</option>
                        <option value="blog" id="blog" <?= ($this->doBlogExist ? 'disabled' : '')?> <?= ($isEditing && $this->article->getType() === 'blog') ? 'selected' : '' ?>>Blog</option>
                    </select>
                    <?= $this->doBlogExist ? '<p class="text-sm pt-2 text-gray-500">Vous ne pouvez pas créer un article de type "Blog" car un article de ce type existe déjà.</p>' : '' ?>
                </div>

                <!-- Contenu avec CKEditor 5 -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="content">Contenu</label>
                    <textarea name="content" id="content" class="textarea textarea-bordered w-full" rows="10" formnovalidate><?= $isEditing ? htmlspecialchars($this->article->getContent()) : '' ?></textarea>
                </div>

                <!-- Image (URL) -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="img">Image (URL)</label>
                    <input type="text" name="img" id="img" class="input input-bordered w-full"
                        value="<?= $isEditing ? htmlspecialchars($this->article->getImg()) : '' ?>">
                </div>

                <!-- Produits associés -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="products">Produits associés</label>
                        <div class="flex gap-2 mb-2">
                            <input type="text" id="productSearch" list="productsList" class="input input-bordered" 
                                   placeholder="Chercher un produit..." autocomplete="off">
                            <datalist id="productsList">
                            </datalist>
                            <button type="button" id="addSelectedProduct" class="btn btn-sm btn-primary">Ajouter</button>
                        </div>
                        <div id="productContainer" class="flex gap-4 mt-2">
                            <?php if ($isEditing && count($this->associatedProducts) !== 0): ?>
                                <?php foreach ($this->associatedProducts as $productId): 
                                    $productEntity = $productModel->getProductbyId($productId); ?>
                                    <div class="flex flex-col w-1/4 items-center justify-center p-2 border rounded mb-1">
                                        <img src="<?= htmlspecialchars($productEntity->getFirstImage()) ?>" 
                                        alt="<?= htmlspecialchars($productEntity->getProduct()) ?>" 
                                        class="w-16 h-16 rounded-md mr-2">
                                        <span><?= htmlspecialchars($productEntity->getProduct()) ?></span>
                                        <input type="hidden" name="selectedProducts[]" value="<?= htmlspecialchars($productEntity->getProductId()) ?>">
                                        <button type="button" class="remove-product btn btn-sm btn-error">×</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <!-- <button type="button" id="addProductBtn" class="btn btn-primary mt-2">✚ Ajouter un produit</button> -->
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Enregistrer les modifications' : 'Créer l\'article' ?>
                    </button>
                    <a href="/admin/articles" class="btn btn-secondary ml-2">Annuler</a>
                </div>
            </form>
        </div>

        <!-- Intégration de CKEditor 5 avec l'adaptateur d'upload d'image -->
        <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView(
            $contentPage,
            $isEditing ? "Modifier l'article" : "Créer un article",
            "",
            ['backoffice', 'createEditArticle']
        ))->show();
    }
}
?>