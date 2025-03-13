<?php

class BackOrderController
{
    private $purchaseModel;
    private $userModel;
    private $addressModel;
    private $purchaseDetailsModel;

    public function __construct() 
    {
        $this->purchaseModel = new PurchaseModel();
        $this->userModel = new UserModel();
        $this->addressModel = new AdressesModel();
        $this->purchaseDetailsModel = new PurchaseDetailsModel();
    }

    public function showAllOrders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
                exit;
            }

            $jwtManager = new JWT();
            $userId = $jwtManager->getUserIdFromJWT();
            if (!$userId) {
                header('Location: /login');
                exit;
            }

            $enumsStatus = EnumControllers::getStatusOptions();
            $purchaseList = $this->purchaseModel->getAllPurchases();

            // Enrichir les données des commandes
            foreach ($purchaseList as $purchase) {
                $user = $this->userModel->getUserById($purchase->getUserId());
                if ($user) {
                    $purchase->hydrate(['user' => $user]);
                }
            }

            $view = new BackOrderView();
            $view->showAllOrders($purchaseList, $enumsStatus);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function showOrderDetail($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
                exit;
            }

            $jwtManager = new JWT();
            $userId = $jwtManager->getUserIdFromJWT();
            if (!$userId) {
                header('Location: /login');
                exit;
            }

            // Nettoyer l'ID de la commande
            $cleanId = preg_replace('/[^0-9]/', '', $id);
            
            // Récupérer les détails de la commande
            $order = $this->purchaseModel->getPurchaseByIdAdmin($cleanId);
            
            if (!$order) {
                throw new Exception("Commande non trouvée");
            }

            // Enrichir avec les données utilisateur
            $user = $this->userModel->getUserById($order->getUserId());
            if ($user) {
                $order->hydrate(['user' => $user]);
            }

            // Enrichir avec l'adresse
            $address = $this->addressModel->getAddressesByUserId($order->getUserId());
            if ($address) {
                $order->hydrate(['address' => $address]);
            }

            // Récupérer les produits de la commande
            $products = $this->purchaseDetailsModel->getPurchaseDetailsByPurchaseId($order->getPurchaseId());
            if ($products) {
                $order->hydrate(['products' => $products]);
            }

            $view = new BackOrderView();
            $view->showOrderDetail($order);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
