<?php

class BackArticleController
{

    private ?ArticleEntity $article;
    private int $articleId;

    public function __construct($articleId = null)
    {
        if ($articleId !== null) {
            $articleModel = new ArticleModel();
            $this->article = $articleModel->getArticleById($articleId);
            $this->articleId = $articleId;
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
}
