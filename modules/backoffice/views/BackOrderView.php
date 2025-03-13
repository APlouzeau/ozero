<?php

class BackOrderView extends View
{

    public function showAllOrders($purchasesList, $enumsStatus)
    {
        ob_start();
        ?>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Liste des commandes</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left">ID</th>
                                <th class="px-6 py-3 text-left">Client</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Montant</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchasesList as $purchase): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4"><?= htmlspecialchars($purchase->getPurchaseId()) ?></td>
                                <td class="px-6 py-4">
                                    <?php 
                                    $user = $purchase->getUser();
                                    echo htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName());
                                    ?>
                                </td>
                                <td class="px-6 py-4"><?= htmlspecialchars($purchase->getPurchaseDate()) ?></td>
                                <td class="px-6 py-4"><?= number_format($purchase->getTotalAmount(), 2) ?> €</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full <?= $this->getStatusClass($purchase->getStatus()) ?>">
                                        <?= htmlspecialchars($purchase->getStatus()) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="/admin/commandes/<?= $purchase->getPurchaseId() ?>" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                        Voir détails
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        (new BackOfficePageView($content, 'Commandes', "Commandes", ['order']))->show();
    }

    public function showOrderDetail($order)
    {
        ob_start();
        ?>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Détails de la commande #<?= htmlspecialchars($order->getPurchaseId()) ?></h1>
                    <span class="px-4 py-2 rounded-full <?= $this->getStatusClass($order->getStatus()) ?>">
                        <?= htmlspecialchars($order->getStatus()) ?>
                    </span>
                </div>

                <!-- Informations client -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Informations client</h2>
                        <?php $user = $order->getUser(); ?>
                        <p><?= htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()) ?></p>
                        <?php if (method_exists($user, 'getEmail')): ?>
                            <p><?= htmlspecialchars($user->getEmail()) ?></p>
                        <?php endif; ?>
                        <p>Date de commande : <?= htmlspecialchars($order->getPurchaseDate()) ?></p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-3">Adresse de livraison</h2>
                        <?php $address = $order->getAddress(); ?>
                        <p><?= htmlspecialchars($address->getStreet()) ?></p>
                        <p><?= htmlspecialchars($address->getCity() . ' ' . $address->getZipCode()) ?></p>
                        <p><?= htmlspecialchars($address->getCountry()) ?></p>
                    </div>
                </div>

                <!-- Liste des produits -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-3">Produits commandés</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Produit</th>
                                    <th class="px-6 py-3 text-left">Prix unitaire</th>
                                    <th class="px-6 py-3 text-left">Quantité</th>
                                    <th class="px-6 py-3 text-left">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->getProducts() as $product): ?>
                                <tr class="border-b">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="<?= $this->getProductImage($product) ?>" 
                                                 alt="<?= htmlspecialchars(is_array($product) ? ($product['name'] ?? 'Produit') : $product->getName()) ?>" 
                                                 class="w-16 h-16 object-cover rounded mr-4">
                                            <span><?= htmlspecialchars(is_array($product) ? ($product['name'] ?? 'Produit') : $product->getName()) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4"><?= number_format(is_array($product) ? ($product['unitPrice'] ?? $product['price'] ?? 0) : $product->getPrice(), 2) ?> €</td>
                                    <td class="px-6 py-4"><?= htmlspecialchars(is_array($product) ? ($product['quantity'] ?? 1) : $product->getQuantity()) ?></td>
                                    <td class="px-6 py-4"><?= number_format(
                                        (is_array($product) ? ($product['unitPrice'] ?? $product['price'] ?? 0) : $product->getPrice()) * 
                                        (is_array($product) ? ($product['quantity'] ?? 1) : $product->getQuantity()), 
                                        2) ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total de la commande -->
                <div class="flex justify-end">
                    <div class="w-full md:w-1/3">
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center text-lg font-semibold">
                                <span>Total</span>
                                <span><?= number_format($order->getTotalAmount(), 2) ?> €</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de retour -->
            <div class="flex justify-start">
                <a href="/admin/commandes" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Retour à la liste des commandes
                </a>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        (new BackOfficePageView($content, 'Détails de la commande', "Détails de la commande #" . $order->getPurchaseId(), ['order']))->show();
    }

    private function getStatusClass($status)
    {
        return match ($status) {
            'En attente' => 'bg-yellow-100 text-yellow-800',
            'Validée' => 'bg-green-100 text-green-800',
            'Annulée' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    private function getProductImage($product)
    {
        // Si c'est un objet avec une méthode getImages
        if (is_object($product) && method_exists($product, 'getImages')) {
            $images = $product->getImages();
            if (!empty($images)) {
                return htmlspecialchars($images[0]);
            }
        } 
        // Si c'est un tableau avec une clé image_path
        else if (is_array($product) && isset($product['image_path'])) {
            return htmlspecialchars($product['image_path']);
        }
        // Si c'est un tableau avec une clé images
        else if (is_array($product) && isset($product['images'])) {
            $images = $product['images'];
            if (!empty($images)) {
                return htmlspecialchars($images[0]);
            }
        }
        
        return '/public/images/default-product.png';
    }
}
