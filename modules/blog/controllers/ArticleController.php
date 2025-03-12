<?php

use Stripe\Terminal\Location;

class ArticleController
{
    private $articleModel;
    private $article;
    private $articleId;
    private $associatedProducts;
    private $associatedProducts;

    public function __construct($articleId = null)
    {
        // Toujours initialiser le modèle
        $this->articleModel = new ArticleModel();

        if ($articleId) {
            $this->article = $this->articleModel->getArticleById($articleId);
            $this->articleId = $articleId;
            $this->associatedProducts = $this->articleModel->getAssociatedProductsId($articleId);
            $this->associatedProducts = $this->articleModel->getAssociatedProductsId($articleId);
        }
    }

    public function execute()
    {
        $view = new ArticleView($this->article, $this->associatedProducts);
        $view->show();
    }

    public function showBlog()
    {
        $articleBlog = $this->articleModel->getBlogArticle();
        $view = new ArticleView();
        $view->showBlog($articleBlog);
    }

    public function showDiy()
    {
        $articleModel = new ArticleModel();
        $articles = $articleModel->getArticles();
        $view = new ArticleView();
        $view->showDiy($articles);
    }


    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Utils::sendResponse('error', 'Méthode non autorisée');
                return;
            }

            if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['type'])) {
                Utils::sendResponse('error', 'Données invalides');
                return;
            }
            $jwtManager = new JWT();
            $userId = $jwtManager->getUserIdFromJWT();

            if (!$jwtManager->getUserIdFromJWT()) {
                Utils::sendResponse('error', 'Utilisateur non authentifié');
                return;
            };
            $article = new ArticleEntity();
            $article->setTitle($_POST['title']);
            $article->setContent($_POST['content']);
            $article->setImg($_POST['img'] ?? null);
            $article->setType($_POST['type'] ?? null);
            $article->setArticleDate(new DateTime());
            $article->setAuthorId($jwtManager->getUserIdFromJWT());

            $articleId = $this->articleModel->addArticle($article);
            if ($articleId) {
                // Association des produits à l'article
                if (isset($_POST['selectedProducts'])) {
                    $productIds = json_decode($_POST['selectedProducts'],true);
                    $this->articleModel->associateProductsToArticle($articleId, $productIds);
                }
                Utils::sendResponse('success', 'Article créé avec succès', $article);
            } else {
                Utils::sendResponse('error', "Erreur lors de la création de l'article");
            }
        } catch (Exception $e) {
            error_log("Erreur dans ArticleController::create: " . $e->getMessage());
            Utils::sendResponse('error', "Une erreur interne s'est produite");
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::sendResponse('error', 'Méthode non autorisée');
        }

        if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['type'])) {
            Utils::sendResponse('error', 'Données invalides');
        }

        $article = $this->articleModel->getArticleById($this->articleId);
        if (!$article) {
            Utils::sendResponse('error', 'Article non trouvé');
        }

        $article->setTitle($_POST['title']);
        $article->setContent($_POST['content']);
        $article->setImg($_POST['img'] ?? $article->getImg());
        $article->setType($_POST['type'] ?? null);

        if ($this->articleModel->updateArticle($article)) {
            //Mise à jour des produits associés
            if (isset($_POST['selectedProducts'])) {
                $productIds = json_decode($_POST['selectedProducts'],true);
                $this->articleModel->updateAssociationProductsToArticle($this->articleId, $productIds);
            }
            Utils::sendResponse('success', "Article mis à jour avec succès", $article);
        } else {
            Utils::sendResponse('error', "Erreur lors de la mise à jour de l'article");
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::sendResponse('error', 'Méthode non autorisée');
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $articleId = $data['articleId'];

        $article = $this->articleModel->getArticleById($articleId); // Utilisation du modèle pour récupérer l'article
        if (!$article) {
            Utils::sendResponse('error', 'Article non trouvé');
        }

        if ($this->articleModel->deleteArticle($articleId)) {
            Utils::sendResponse('success', 'Article supprimé avec succès');
        } else {
            Utils::sendResponse('error', "Erreur lors de la suppression de l'article");
        }
    }

    /**
     * Endpoint pour l'upload d'image via CKEditor.
     *
     * Ce endpoint reçoit le fichier envoyé par l'éditeur,
     * le sauvegarde dans un dossier dédié et retourne l'URL publique de l'image.
     *
     * @return void
     */
    public function uploadImage()
    {
        // Vérifier que la méthode HTTP est POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::sendResponse('error', 'Méthode non autorisée');
        }

        // Vérifier le CSRF token dans le header (si utilisé)
        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (SessionController::verifyCSRFToken($csrfToken)) {
            Utils::sendResponse('error', 'CSRF token invalide');
        }

        // Vérifier qu'un fichier a bien été uploadé (la clé "upload" est utilisée par CKEditor)
        if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
            Utils::sendResponse('error', 'Aucun fichier uploadé ou erreur lors de l\'upload');
        }

        // Valider le type MIME du fichier (seuls certains types d'images sont autorisés)
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $_FILES['upload']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimeTypes)) {
            Utils::sendResponse('error', 'Type de fichier non autorisé');
        }

        // Vérifier la taille du fichier (exemple : maximum 5 Mo)
        $maxFileSize = 5 * 1024 * 1024; // 5 Mo
        if ($_FILES['upload']['size'] > $maxFileSize) {
            Utils::sendResponse('error', 'Fichier trop volumineux');
        }

        // Définir le dossier de destination (assurez-vous que ce dossier est accessible en écriture)
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/articles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Générer un nom de fichier unique
        $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img', true) . '.' . $extension;
        $destination = $uploadDir . $filename;

        // Déplacer le fichier uploadé dans le dossier de destination
        if (!move_uploaded_file($_FILES['upload']['tmp_name'], $destination)) {
            Utils::sendResponse('error', 'Échec de la sauvegarde du fichier');
        }

        // Construire l'URL publique de l'image (supposant que "public" est la racine accessible du site)
        $imageUrl = '/uploads/articles/' . $filename;

        // Renvoyer la réponse JSON attendue par CKEditor
        Utils::sendResponse('success', 'Image téléchargée avec succès', ['url' => $imageUrl]);
    }
}
