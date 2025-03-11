<?php

class BackArticleView extends View {

    public function show() {
        $articleModel = new ArticleModel();
        $articles = $articleModel->getArticles();

        ob_start();
        ?>
        <!-- Contenu principal -->
        <div class="flex flex-col gap-4 justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Gestion des articles DIY</h1>
            <a href="/admin/articles/create" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un article
            </a>
        </div>

        <!-- Tableau des articles -->
        <div class="overflow-x-auto rounded-lg border border-base-200">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Titre</th>
                    <th class="text-sm font-bold">Auteur</th>
                    <th class="text-sm font-bold">Date de publication</th>
                    <th class="text-sm font-bold">Statut</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article->getArticleId()) ?></td>
                        <td><?= htmlspecialchars($article->getTitle()) ?></td>
                        <td><?= htmlspecialchars($article->getAuthorName()) ?></td>
                        <td><?= htmlspecialchars($article->getArticleDate()->format('Y-m-d H:i:s')) ?></td>
                        <td>
                            <?php if (!empty($article->getArticleId())): ?>
                                <span class="badge badge-success">Publié</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Brouillon</span>
                            <?php endif; ?>
                        </td>
                        <td class="flex gap-2">
                            <a href="/admin/articles/edit/<?= $article->getArticleId() ?>" class="btn btn-sm btn-info">
                                Modifier
                            </a>
                            <!-- <a href="/admin/articles/delete/<?= $article->getArticleId() ?>"
                               class="btn btn-sm btn-error"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                Supprimer
                            </a> -->
                            <button class="btn btn-sm btn-error"
                                    data-article-id="<?= $article->getArticleId() ?>">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php $this->renderDeleteModal(); ?>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Administration des articles', "Gestion des articles de blog.",
        ['backoffice', 'createEditArticle']))->show();
    }

    private function renderDeleteModal() {
        ?>
        <input type="checkbox" id="delete-article-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                <p class="py-4">Êtes-vous sûr de vouloir supprimer définitivement cet article ?</p>
                <form method="POST" action="/admin/article/delete" id="delete-form">
                    <input type="hidden" name="articleId" id="delete-article-id">
                    <div class="modal-action">
                        <button type="submit" class="btn btn-error">Supprimer</button>
                        <label for="delete-product-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
