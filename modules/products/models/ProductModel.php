<?php

class ProductModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    /**
     * Récupère un produit par son ID
     *
     * @param int $productId
     * @return ProductEntity|null
     */
    public function getProductById(int $productId): ?ProductEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($product) {
            // Créer l'entité Product sans images
            $productEntity = $this->mapToEntity($product);
            // Ajouter les images après la création de l'entité
            $images = $this->getProductImages($productId);
            $productEntity->setImages($images); // Méthode pour définir les images dans l'entité
            return $productEntity;
        }
        return null;
    }

    /**
     * Récupère tous les produits
     *
     * @return ProductEntity[]
     */
    public function getAllProducts(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY createdAt DESC");
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $productEntities = [];
        foreach ($products as $product) {
            $productEntities[] = $this->mapToEntity($product);
        }

        return $productEntities;
    }

    /**
     * Ajoute un nouveau produit
     *
     * @param string $product
     * @param string|null $description
     * @param float $price
     * @param string|null $img
     * @param int $stock
     * @return int|null
     */
    public function addProduct(string $product, ?string $description, float $price, ?string $img, int $stock): int|null
    {
        $stmt = $this->db->prepare("INSERT INTO products (product, description, price, img, stock) VALUES (:product, :description, :price, :img, :stock)");
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);

        $stmt->execute();
        return (int) $this->db->lastInsertId();
    }

    /**
     * Met à jour un produit existant
     *
     * @param int $productId
     * @param string $product
     * @param string|null $description
     * @param float $price
     * @param string|null $img
     * @param int $stock
     * @return bool
     */
    public function updateProduct(int $productId, string $product, ?string $description, float $price, ?string $img, int $stock): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET product = :product, description = :description, price = :price, img = :img, stock = :stock WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un produit par son ID
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProduct(int $productId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE productId = :productId");
        $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Ajoute une image pour un produit
     *
     * @param int $productId
     * @param string $imagePath
     * @return bool
     */
    public function addProductImages(int $productId, string $imagePath): bool
    {
        $sql = "INSERT INTO productsImages (productId, image_path) VALUES (:productId, :image_path)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Ajoute une catégorie à un produit
     * @param int $productId
     * @param int $categoryId
     * @return bool
     */
    public function addProductCategory(int $productId, int $categoryId): bool
    {
        $sql = "INSERT INTO productCategory (productId, categoryId) VALUES (:productId, :categoryId)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère la catégorie associée au produit
     * @param int $productId
     * @return int|null
     */
    public function getIdCategoryByProduct(int $productId): ?int
    {
        $sql = "SELECT categoryId FROM productCategory WHERE productId = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? (int)$result['categoryId'] : null;
    }

    /**
     * Supprime une catégorie d'un produit
     * @param int $productId
     * @param int $categoryId
     * @return bool
     */
    public function deleteProductCategory(int $productId, int $categoryId): bool
    {
        $sql = "DELETE FROM productCategory WHERE productId = :productId AND categoryId = :categoryId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Update la catégorie d'un produit
     * @param int $productId
     * @param int $categoryId
     * @return bool
     */
    public function updateProductCategory(int $productId, int $categoryId): bool
    {
        $sql = "UPDATE productCategory SET categoryId = :categoryId WHERE productId = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Convertit les résultats de la base de données en objet ProductEntity
     *
     * @param array $data
     * @return ProductEntity
     */
    private function mapToEntity(array $data): ProductEntity
    {
        $price = (float) $data['price'];
        $createdAt = new \DateTime($data['createdAt']);

        // Récupérer les images du produit (si elles existent)
        $images = $this->getProductImages($data['productId']);

        $productEntity = new ProductEntity(
            $data['productId'],
            $data['product'],
            $price,
            $data['stock'],
            $createdAt,
            $data['description'] ?? null,
            $images
        );

        return $productEntity;
    }

    /**
     * Récupère toutes les images associées à un produit
     *
     * @param int $productId
     * @return array
     */
    public function getProductImages(int $productId): array
    {
        $stmt = $this->db->prepare("SELECT image_path FROM productsImages WHERE productId = :productId ORDER BY id ASC");
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $images = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $images[] = $row['image_path'];
        }
        return $images;
    }

    /**
     * Récupère la première image associée à un produit
     *
     * @param int $productId
     * @return string|null Le chemin de l'image ou null si aucune image n'est trouvée
     */
    public function getFirstProductImage(int $productId): ?string
    {
        $sql = "SELECT image_path FROM productsImages WHERE productId = :productId ORDER BY id ASC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        return $image ? $image['image_path'] : null;
    }

    /**
     * Supprime une image d'un produit
     *
     * @param int $productId
     * @param string $imagePath
     * @return bool
     */
    public function deleteProductImage(int $productId, string $imagePath): bool
    {
        $sql = "DELETE FROM productsImages WHERE productId = :productId AND image_path = :image_path";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Vérifier si l'image est associée au produit
    public function isImageAssociatedWithProduct($productId, $imagePath)
    {
        // Requête pour vérifier si l'image appartient bien au produit
        $sql = "SELECT COUNT(*) FROM productsImages WHERE productId = :productId AND image_path = :image_path";

        // Exécution de la requête préparée
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);

        // Exécuter et récupérer le nombre de résultats
        $stmt->execute();
        $result = $stmt->fetchColumn();

        // Si le résultat est supérieur à 0, l'image est associée au produit
        return $result > 0;
    }

    /**
     * Supprime toutes les images associées à un produit
     *
     * @param int $productId
     * @return bool
     */
    public function deleteAllProductImages(int $productId): bool
    {
        $sql = "DELETE FROM productsImages WHERE productId = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
