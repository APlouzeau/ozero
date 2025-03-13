<?php


class PurchaseDetailsModel
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function newPurchaseDetail(PurchaseDetailsEntity $purchaseDetail)
    {
        $stmt = $this->db->prepare('INSERT INTO purchaseDetails (purchaseId, productId, quantity, unitPrice) VALUES (:purchaseId, :productId, :quantity, :unitPrice)');
        $stmt->bindValue(':purchaseId', $purchaseDetail->getPurchaseId(), PDO::PARAM_INT);
        $stmt->bindValue(':productId', $purchaseDetail->getProductId(), PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $purchaseDetail->getQuantity(), PDO::PARAM_INT);
        $stmt->bindValue(':unitPrice', $purchaseDetail->getunitPrice(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getPurchaseDetailsByPurchaseId($purchaseId): array
    {
        $stmt = $this->db->prepare('
        SELECT pd.*, 
               p.product as name,
               p.description,
               p.price,
               CASE 
                   WHEN p.img LIKE "http%" THEN p.img
                   WHEN p.img LIKE "https%" THEN p.img
                   WHEN p.img IS NOT NULL THEN CONCAT("/uploads/products/", p.img)
                   ELSE NULL
               END as image_path,
               CASE 
                   WHEN p.img LIKE "http%" THEN p.img
                   WHEN p.img LIKE "https%" THEN p.img
                   WHEN p.img IS NOT NULL THEN CONCAT("/uploads/products/", p.img)
                   ELSE NULL
               END as images
        FROM purchaseDetails pd
        INNER JOIN products p ON p.productId = pd.productId 
        WHERE pd.purchaseId = :purchaseId');
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
        $datas = $stmt->fetchAll();
        return $datas;
    }
}
