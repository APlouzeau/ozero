<?php

class OrderView extends View
{
    public function showOrders($purchasesList)
    {
        ob_start();
        $count = count($purchasesList);
?>
        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Mes commandes</h1>
                    <p class="text-gray-600">Historique et suivi de vos achats</p>
                </div>
                
                <input type="hidden" name="count" id="rows" value="<?= $count ?>">

                <?php if (empty($purchasesList)): ?>
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande pour le moment</h3>
                    <p class="text-gray-600 mb-4">Vous n'avez pas encore effectué de commande.</p>
                    <a href="/catalogue" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Découvrir nos produits
                    </a>
                </div>
                <?php else: ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° de commande</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de commande</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($purchasesList as $purchase) { ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out" id=<?= $purchase->getPurchaseId() ?>>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#<?= $purchase->getPurchaseId() ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= $purchase->getPurchaseDate() ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium"><?= $purchase->getTotalAmount() ?> €</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php 
                                                $statusClass = '';
                                                $status = $purchase->getStatus();
                                                
                                                switch (strtolower($status)) {
                                                    case 'en attente':
                                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'confirmée':
                                                    case 'confirmee':
                                                    case 'validée':
                                                    case 'validee':
                                                        $statusClass = 'bg-green-100 text-green-800';
                                                        break;
                                                    case 'annulée':
                                                    case 'annulee':
                                                        $statusClass = 'bg-red-100 text-red-800';
                                                        break;
                                                    case 'expédiée':
                                                    case 'expediee':
                                                        $statusClass = 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'livrée':
                                                    case 'livree':
                                                        $statusClass = 'bg-green-100 text-green-800';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-gray-100 text-gray-800';
                                                }
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>"><?= $status ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <a href="/order/details/<?= $purchase->getPurchaseId() ?>" class="text-green-600 hover:text-green-900 font-medium">Voir détails</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    <?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commandes', "Commandes", ['debug', 'order']))->show();
    }

    public function Order($purchaseId, $purchaseDate, $totalAmount, $status)
    {
        ob_start();
    ?>
        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Détails de commande</h1>
                    <p class="text-gray-600">Récapitulatif de votre commande #<?= $purchaseId ?></p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Commande #<?= $purchaseId ?></h2>
                                <p class="mt-1 text-sm text-gray-600">Passée le <?= $purchaseDate ?></p>
                            </div>
                            <?php 
                                $statusClass = '';
                                switch (strtolower($status)) {
                                    case 'en attente':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'confirmée':
                                    case 'confirmee':
                                    case 'validée':
                                    case 'validee':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    case 'annulée':
                                    case 'annulee':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    case 'expédiée':
                                    case 'expediee':
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'livrée':
                                    case 'livree':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                }
                            ?>
                            <div class="mt-3 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                                    <?= $status ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Récapitulatif</h3>
                        <div class="border-t border-gray-200 pt-4">
                            <dl class="divide-y divide-gray-200">
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-600">Montant total</dt>
                                    <dd class="text-gray-900 font-medium"><?= $totalAmount ?> €</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <a href="/commandes" class="text-green-600 hover:text-green-900 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Retour à mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commande', "Commande", ['debug', 'order']))->show();
    }

    public function showOrderDetails($purchase, $purchaseDetails)
    {
        ob_start();
    ?>
        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Détails de commande</h1>
                    <p class="text-gray-600">Commande #<?= $purchase->getPurchaseId() ?></p>
                </div>
                
                <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Informations générales</h2>
                                <p class="mt-1 text-sm text-gray-600">Commande passée le <?= $purchase->getPurchaseDate() ?></p>
                            </div>
                            <?php 
                                $statusClass = '';
                                $status = $purchase->getStatus();
                                
                                switch (strtolower($status)) {
                                    case 'en attente':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'confirmée':
                                    case 'confirmee':
                                    case 'validée':
                                    case 'validee':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    case 'annulée':
                                    case 'annulee':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    case 'expédiée':
                                    case 'expediee':
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'livrée':
                                    case 'livree':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                }
                            ?>
                            <div class="mt-3 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                                    <?= $status ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Produits commandés</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($purchaseDetails as $product) { ?>
                                    <tr class="hover:bg-gray-50" id="<?= $product['productId'] ?>">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $product['name'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= $product['price'] ?> €</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= $product['quantity'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php 
                                                // Vérifier si la clé 'total' existe, sinon calculer le total
                                                if (isset($product['total'])) {
                                                    echo $product['total'];
                                                } else {
                                                    // Calculer le total à partir du prix unitaire et de la quantité
                                                    echo number_format($product['price'] * $product['quantity'], 2);
                                                }
                                            ?> €
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <th scope="row" colspan="3" class="px-6 font py-3 text-left text-sm font-bold text-gray-900">Total commande</th>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-gray-900"><?= $purchase->getTotalAmount() ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <a href="/commandes" class="text-green-600 hover:text-green-900 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Retour à mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commande', "Commande", ['debug', 'orderDetails']))->show();
    }
}
