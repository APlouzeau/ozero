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
     * Ajoute un article à la base de données
     *
     * @param ArticleEntity $articleEntity
     * @return bool
     */
    public function addArticle(ArticleEntity $articleEntity): bool
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

        return $stmt->execute([
            ':title'       => $title,
            ':articleDate' => $articleDate,
            ':content'     => $content,
            ':img'         => $img,
            ':type'        => $type,
            ':authorId'    => $authorId
        ]);
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
}
