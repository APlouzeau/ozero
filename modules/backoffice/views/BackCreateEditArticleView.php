<?php

class BackCreateEditArticleView extends View
{
    /**
     * @var ArticleEntity|null
     */
    private ?ArticleEntity $article;

    /**
     * Constructeur.
     *
     * @param ArticleEntity|null $article Si un article est fourni, la vue sera en mode édition. Sinon, en mode création.
     */
    public function __construct($article = null)
    {
        $this->article = $article;
    }

    public function show(): void
    {
        $isEditing = $this->article !== null;
        ob_start();

?>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">
                <?= $isEditing ? 'Modifier l\'article' : 'Créer un nouvel article' ?>
            </h1>
            <div id="flashMessageContainer"></div>
            <form method="POST" action="<?= $isEditing ? ('/admin/articles/update/' . $this->article->getArticleId()) : '/admin/articles/create' ?>">
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
                        <option value="blog" <?= ($isEditing && $this->article->getType() === 'blog') ? 'selected' : '' ?>>Blog</option>
                        <option value="diy" <?= ($isEditing && $this->article->getType() === 'diy') ? 'selected' : '' ?>>DIY</option>
                    </select>
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