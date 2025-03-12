<?php

class ArticleModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    /**
     * Récupère un article par son ID
     *
     * @param int $articleId
     * @return ArticleEntity|null
     */
    public function getArticleById(int $articleId): ?ArticleEntity
    {
        $stmt = $this->db->prepare("
        SELECT a.*, u.firstName, u.lastName, CONCAT(u.firstName, ' ', u.lastName) AS authorName 
        FROM articles a
        LEFT JOIN users u ON a.authorId = u.userId
        WHERE a.articleId = :articleId
    ");
        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
        $stmt->execute();

        $article = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($article) {
            return $this->mapToEntity($article);
        }
        return null;
    }

    /**
     * Vérifie si un article de type Blog existe déjà
     * @return bool
     */
    public function doBlogExist(): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM articles WHERE type = 'blog'");
        $stmt->execute();
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Récupère tous les articles
     *
     * @return ArticleEntity[]
     */
    public function getArticles(): array
    {
        $stmt = $this->db->prepare("
        SELECT a.*, u.firstName, u.lastName 
        FROM articles a
        LEFT JOIN users u ON a.authorId = u.userId
    ");
        $stmt->execute();

        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $articleEntities = [];

        foreach ($articles as $article) {
            // Ajouter les informations de l'auteur à l'entité Article
            $articleEntities[] = $this->mapToEntity($article);
        }

        return $articleEntities;
    }


    /**
     * Ajoute un article à la base de données et retourne l'id généré
     *
     * @param ArticleEntity $articleEntity
     * @return int|null
     */
    public function addArticle(ArticleEntity $articleEntity): int|null
    {
        $title = $articleEntity->getTitle();
        $articleDate = $articleEntity->getArticleDate()
            ? $articleEntity->getArticleDate()->format('Y-m-d')
            : (new \DateTime())->format('Y-m-d');
        $content = $articleEntity->getContent();
        $img = $articleEntity->getImg();
        $type = $articleEntity->getType();
        $authorId = $articleEntity->getAuthorId();

        $stmt = $this->db->prepare("INSERT INTO articles (title, articleDate, content, type, img, authorId) 
            VALUES (:title, :articleDate, :content, :type, :img, :authorId)");

        $stmt->execute([
            ':title'       => $title,
            ':articleDate' => $articleDate,
            ':content'     => $content,
            ':img'         => $img,
            ':type'        => $type,
            ':authorId'    => $authorId
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Associe des produits à un article
     * @param int $articleId
     * @param array $productIds
     * @return bool
     */
    public function associateProductsToArticle(int $articleId, array $productIds): bool
    {
        $stmt = $this->db->prepare("INSERT INTO productByArticle (productId, articleId) VALUES (:productId, :articleId)");

        try {
            foreach ($productIds as $productId) {
                $stmt->execute([
                    ':productId' => $productId,
                    ':articleId' => $articleId
                ]);
            }
            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, on ne fait rien
            return false;
        }
    }

    /**
     * Update l'association des produits à un article
     * @param int $articleId
     * @param array $productIds
     * @return bool
     */
    public function updateAssociationProductsToArticle(int $articleId, array $productIds): bool
    {
        // Suppression de toutes les associations existantes
        $stmt = $this->db->prepare("DELETE FROM productByArticle WHERE articleId = :articleId");
        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
        $stmt->execute();

        // Ajout des nouvelles associations
        $stmt = $this->db->prepare("INSERT INTO productByArticle (productId, articleId) VALUES (:productId, :articleId)");

        try {
            foreach ($productIds as $productId) {
                $stmt->execute([
                    ':productId' => $productId,
                    ':articleId' => $articleId
                ]);
            }
            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, on ne fait rien
            return false;
        }
    }
    

    /**
     * Récupère les produits associés à un article
     *
     * @param int $articleId
     * @return array
     */
    public function getAssociatedProductsId(int $articleId): array
    {
        $stmt = $this->db->prepare("SELECT productId FROM productByArticle WHERE articleId = :articleId");
        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Met à jour un article
     *
     * @param ArticleEntity $articleEntity
     * @return bool
     */
    public function updateArticle(ArticleEntity $articleEntity): bool
    {
        $articleId = $articleEntity->getArticleId();
        $title = $articleEntity->getTitle();
        $articleDate = $articleEntity->getArticleDate() ? $articleEntity->getArticleDate()->format('Y-m-d') : null;
        $content = $articleEntity->getContent();
        $img = $articleEntity->getImg();
        $authorId = $articleEntity->getAuthorId();
        $type = $articleEntity->getType();


        $stmt = $this->db->prepare("UPDATE articles 
            SET title = :title, articleDate = :articleDate, content = :content, img = :img, authorId = :authorId, type = :type 
            WHERE articleId = :articleId");

        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':articleDate', $articleDate, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':img', $img, \PDO::PARAM_STR);
        $stmt->bindParam(':authorId', $authorId, \PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Supprime un article
     *
     * @param int $articleId
     * @return bool
     */
    public function deleteArticle(int $articleId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE articleId = :articleId");
        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Mappe les données de la base de données vers une entité ArticleEntity
     *
     * @param array $data
     * @return ArticleEntity
     */
    private function mapToEntity(array $data): ArticleEntity
    {
        $articleEntity = new ArticleEntity();

        $articleEntity->setArticleId($data['articleId'])
            ->setTitle($data['title'])
            ->setArticleDate($data['articleDate'])
            ->setContent($data['content'])
            ->setImg($data['img'])
            ->setAuthorId($data['authorId'])
            ->setType($data['type']);


        // Ajouter le nom de l'auteur
        $authorName = $data['firstName'] . ' ' . $data['lastName'];
        $articleEntity->setAuthorName($authorName);

        return $articleEntity;
    }

    /**
     * Récupère toutes les catégories liées à tous les produits liés à un article.
     *
     * @param int $articleId
     * @return array
     */
    public function getCategoriesByArticleId(int $articleId): array
    {
        $sql = "SELECT DISTINCT c.name 
                FROM categories c
                INNER JOIN productCategory pc ON c.categoryId = pc.categoryId
                INNER JOIN products p ON pc.productId = p.productId
                INNER JOIN productByArticle pa ON p.productId = pa.productId
                WHERE pa.articleId = :articleId";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
