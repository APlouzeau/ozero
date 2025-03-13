<?php

class BasketController
{
    public function execute()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $view = new BasketView();
        $view->show();
    }

    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $productsModel = new ProductModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            for ($i = 0; $i < count($_POST['productId']); $i++) {
                $productId = $_POST['productId'][$i];
                
                // Récupérer le produit complet via l'entité
                $productEntity = $productsModel->getProductById($productId);
                
                if ($productEntity) {
                    if (isset($_SESSION['cart'][$productId])) {
                        $_SESSION['cart'][$productId]['quantity'] += (int)$_POST['quantity'][$i];
                    } else {
                        $_SESSION['cart'][$productId] = [
                            'productId' => $productId,
                            'product' => $productEntity->getProduct(),
                            'price' => $productEntity->getPrice(),
                            'quantity' => (int)$_POST['quantity'][$i],
                            'images' => $productEntity->getImages() ?? []
                        ];
                    }
                }
            }
            $view = new BasketView();
            $view->show();
        } else {
            $view = new page404View();
            $view->show();
        }
    }

    public function addOneToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);
        $productId = $jsonData['productId'] ?? null;
        $quantity = max(0, (int)($jsonData['quantity'] ?? 0));

        if ($productId) {
            $productsModel = new ProductModel();
            $productEntity = $productsModel->getProductById($productId);

            if ($productEntity) {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'productId' => $productId,
                        'product' => $productEntity->getProduct(),
                        'price' => $productEntity->getPrice(),
                        'quantity' => $quantity,
                        'images' => $productEntity->getImages() ?? []
                    ];
                }

                // Calculer le nouveau total
                $totalAmount = $this->calculateCartTotal();

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'session' => $_SESSION['cart'],
                    'totalAmount' => $totalAmount,
                    'message' => 'Quantité mise à jour'
                ]);
                exit;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Produit non trouvé'
        ]);
        exit;
    }

    public function removeOneToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $jsonData = json_decode(file_get_contents('php://input'), true);
        $productId = $jsonData['productId'] ?? null;
        $quantity = max(0, (int)($jsonData['quantity'] ?? 0));

        if ($productId) {
            if ($quantity <= 0) {
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                }
            } else {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                }
            }

            // Calculer le nouveau total
            $totalAmount = $this->calculateCartTotal();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'session' => $_SESSION['cart'],
                'totalAmount' => $totalAmount,
                'message' => $quantity <= 0 ? 'Produit supprimé du panier' : 'Quantité mise à jour'
            ]);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Produit non trouvé'
        ]);
        exit;
    }

    private function calculateCartTotal()
    {
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalAmount += (float)$item['price'] * (int)$item['quantity'];
        }
        return round($totalAmount, 2);
    }

    public function testPanier()
    {
        $productModel = new ProductModel();
        $productList = $productModel->getAllProducts();
        $view = new TestAddBasketView();
        $view->show($productList);
    }

    public function checkConnect()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['totalAmount'] = $_POST['totalAmount'];
        try {

            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
            } else {
                $jwtManager = new JWT();
                if (!$jwtManager->getUserIdFromJWT()) {
                    header('Location: /login');
                } else {
                    $addressModel = new AdressesModel();
                    $userModel = new UserModel();
                    $userId = $jwtManager->getUserIdFromJWT();
                    $user = $userModel->getUserById($userId);
                    $addresse = $addressModel->getAddressesByUserId($userId);

                    $view = new BasketView();
                    $view->shipping($user, $addresse);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function confirmation()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $street = htmlspecialchars($_POST['street']);
        $city = htmlspecialchars($_POST['city']);
        $zipCode = htmlspecialchars($_POST['zipCode']);
        $country = htmlspecialchars($_POST['country']);
        $phone = htmlspecialchars($_POST['phone']);
        $_SESSION['addresse'] = [
            'street' => $street,
            'city' => $city,
            'zipCode' => $zipCode,
            'country' => $country,
            'phone' => $phone,
        ];
        $view = new BasketView();
        $view->confirmationPage();
    }
}
