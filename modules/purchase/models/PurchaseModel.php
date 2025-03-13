<?php


class PurchaseModel
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function newPurchase(PurchaseEntity $purchase)
    {
        $stmt = $this->db->prepare('INSERT INTO purchases (userId, totalAmount, status, addressId, paymentMethod) VALUES (:userId, :totalAmount, :status, :addressId, :paymentMethod)');
        $stmt->bindValue(':userId', $purchase->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':totalAmount', $purchase->getTotalAmount(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $purchase->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':addressId', $purchase->getAddressId(), PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethod', $purchase->getPaymentMethod(), PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updatePurchaseStatus($purchaseId, string $status)
    {
        $stmt = $this->db->prepare('UPDATE purchases SET status = :status WHERE purchaseId = :purchaseId');
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllPurchasesById($userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM purchases WHERE userId = :userId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $purchasesList = [];
        foreach ($datas as $data) {
            $purchasesList[] = new PurchaseEntity($data);
        }
        return $purchasesList;
    }

    public function getPurchaseById($userId, $purchaseId): ?PurchaseEntity
    {
        $stmt = $this->db->prepare('SELECT * FROM purchases WHERE userId = :userId AND purchaseId = :purchaseId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new PurchaseEntity($result) : null;
    }

    public function getAllPurchases(): array
    {
        $stmt = $this->db->query('SELECT * FROM purchases WHERE status != "panier"');
        $datas = $stmt->fetchAll();
        $purchasesList = [];
        foreach ($datas as $data) {
            $purchasesList[] = new PurchaseEntity($data);
        }
        return $purchasesList;
    }

    public function getPurchaseByIdAdmin($purchaseId): ?PurchaseEntity
    {
        $stmt = $this->db->prepare('SELECT * FROM purchases WHERE purchaseId = :purchaseId');
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new PurchaseEntity($result) : null;
    }

    public function getTotalSales()
    {
        $query = "SELECT COALESCE(SUM(totalAmount), 0) as totalAmount 
                 FROM purchases 
                 WHERE status != 'panier'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['totalAmount'];
    }

    public function getCurrentMonthSales()
    {
        $query = "SELECT COALESCE(SUM(totalAmount), 0) as totalAmount 
                 FROM purchases 
                 WHERE status != 'panier'
                 AND MONTH(NOW()) = MONTH(NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['totalAmount'];
    }

    public function getAverageOrderValue()
    {
        $query = "SELECT COALESCE(AVG(totalAmount), 0) as average 
                 FROM purchases 
                 WHERE status != 'panier'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch()['average'];
    }

    public function getRecentOrders($limit = 5)
    {
        $query = "SELECT 
                    p.purchaseId as id, 
                    p.totalAmount as total, 
                    p.status,
                    p.purchaseDate as created_at,
                    CONCAT(u.firstName, ' ', u.lastName) as customer_name 
                 FROM purchases p 
                 JOIN users u ON p.userId = u.userId 
                 WHERE p.status != 'panier'
                 ORDER BY p.purchaseDate DESC 
                 LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
