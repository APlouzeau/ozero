<?php

class BackArticleController
{

    private ?ArticleEntity $article;
    private int $articleId;
    private ?array $associatedProducts;

    public function __construct($articleId = null)
    {
        if ($articleId !== null) {
            $articleModel = new ArticleModel();
            $this->article = $articleModel->getArticleById($articleId);
            $this->articleId = $articleId;
            // Récupération des produits associés à l'article
            $this->associatedProducts = $articleModel->getAssociatedProductsId($articleId);
        }
    }

    /**
     * Affiche la vue principale du backoffice.
     *
     * @return void
     */
    public function execute()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $view = new BackArticleView();
        $view->show();
    }

    /**
     * Affiche la vue de création d'article.
     *
     * @return void
     */
    public function create()
    {
        $view = new BackCreateEditArticleView();
        $view->show();
    }

    /**
     * Affiche la vue de modification d'un article
     * 
     * @return void
     */
    public function edit()
    {
        $view = new BackCreateEditArticleView($this->article, $this->associatedProducts);
        $view->show();
    }
}
