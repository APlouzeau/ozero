<?php

class CategoryModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    /**
     * Récupère une catégorie par son ID
     *
     * @param int $categoryId
     * @return CategoryEntity|null
     */
    public function getCategoryById(int $categoryId): ?CategoryEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE categoryId = :categoryId");
        $stmt->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();

        $category = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($category) {
            return $this->mapToEntity($category);
        }
        return null;
    }

    /**
     * Récupère toutes les catégories
     *
     * @return CategoryEntity[]
     */
    public function getAllCategories(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();

        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $categoryEntities = [];

        foreach ($categories as $category) {
            $categoryEntities[] = $this->mapToEntity($category);
        }

        return $categoryEntities;
    }

    /**
     * Ajoute une nouvelle catégorie
     *
     * @param string $name
     * @param int|null $parentCategoryId
     * @return int|null
     */
    public function addCategory(string $name, ?int $parentCategoryId = null): int|null
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, parentCategoryId) VALUES (:name, :parentCategoryId)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':parentCategoryId', $parentCategoryId, \PDO::PARAM_INT);

        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour une catégorie existante
     *
     * @param int $categoryId
     * @param string $name
     * @param int|null $parentCategoryId
     * @return bool
     */
    public function updateCategory(int $categoryId, string $name, ?int $parentCategoryId = null): bool
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, parentCategoryId = :parentCategoryId WHERE categoryId = :categoryId");
        $stmt->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':parentCategoryId', $parentCategoryId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime une catégorie par son ID
     *
     * @param int $categoryId
     * @return bool
     */
    public function deleteCategory(int $categoryId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE categoryId = :categoryId");
        $stmt->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Convertit les résultats de la base de données en objet CategoryEntity
     *
     * @param array $data
     * @return CategoryEntity
     */
    private function mapToEntity(array $data): CategoryEntity
    {
        return new CategoryEntity(
            $data['categoryId'],
            $data['name'],
            $data['parentCategoryId']
        );
    }
}
