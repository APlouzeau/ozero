<?php

class BackArticleView extends View {

    public function show() {
        $articleModel = new ArticleModel();
        $types = ['blog', 'diy'];
        $articles = $articleModel->getArticles($types);

        ob_start();
        ?>
        <!-- Dashboard Header -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 font-chillax">Gestion des articles</h1>
                    <p class="text-gray-500 mt-1">Administration des tutoriels DIY et articles de blog</p>
                </div>
                <a href="/admin/articles/create" class="btn btn-primary gap-2 mt-4 md:mt-0 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvel article
                </a>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary/10 text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total articles</p>
                        <h3 class="text-xl font-bold"><?= count($articles) ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Articles Blog</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $blogCount = count(array_filter($articles, function($article) { 
                                    return $article->getType() === 'blog'; 
                                }));
                                echo $blogCount;
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tutoriels DIY</p>
                        <h3 class="text-xl font-bold">
                            <?php 
                                $diyCount = count(array_filter($articles, function($article) { 
                                    return $article->getType() === 'diy'; 
                                }));
                                echo $diyCount;
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des articles -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Liste des articles</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">ID</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Titre</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Auteur</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Date</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Statut</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Type</th>
                            <th class="text-xs uppercase text-gray-500 font-semibold px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3"><?= htmlspecialchars($article->getArticleId()) ?></td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-gray-800 line-clamp-1"><?= htmlspecialchars($article->getTitle()) ?></div>
                            </td>
                            <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($article->getAuthorName()) ?></td>
                            <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($article->getArticleDate()->format('d/m/Y H:i')) ?></td>
                            <td class="px-4 py-3">
                                <?php if (!empty($article->getArticleId())): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">Publié</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">Brouillon</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full <?= $article->getType() === 'blog' ? 'bg-blue-100 text-blue-600' : 'bg-primary/10 text-primary' ?>">
                                    <?= htmlspecialchars(ucfirst($article->getType())) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="/admin/articles/edit/<?= $article->getArticleId() ?>" 
                                       class="btn btn-sm btn-outline text-blue-600 border-blue-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button class="btn btn-sm btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white group"
                                            data-article-id="<?= $article->getArticleId() ?>"
                                            onclick="confirmDelete(<?= $article->getArticleId() ?>)">
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
        <?php $this->renderDeleteModal(); ?>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Administration des articles', "Gestion des articles de blog.",
        ['backoffice', 'deleteArticle']))->show();
    }

    private function renderDeleteModal() {
        ?>
        <input type="checkbox" id="delete-article-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box bg-white">
                <div class="flex items-center justify-center mb-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center">Confirmer la suppression</h3>
                <p class="py-4 text-gray-600 text-center">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement cet article ?</p>
                <form method="POST" action="/admin/articles/delete" id="delete-form">
                    <input type="hidden" name="articleId" id="delete-article-id">
                    <div class="flex justify-center space-x-3 mt-4">
                        <label for="delete-article-modal" class="btn btn-outline btn-sm px-6">Annuler</label>
                        <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white border-none btn-sm px-6">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
