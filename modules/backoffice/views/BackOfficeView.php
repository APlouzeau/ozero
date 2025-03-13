<?php

class BackOfficeView extends View {
    private $purchaseModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        $this->purchaseModel = new PurchaseModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    private function getStatistics() {
        $totalSales = $this->purchaseModel->getTotalSales();
        $monthSales = $this->purchaseModel->getCurrentMonthSales();
        $totalUsers = $this->userModel->getTotalUsers();
        $totalProducts = $this->productModel->getTotalProducts();
        $averageOrderValue = $this->purchaseModel->getAverageOrderValue();
        $bestSellingProducts = $this->productModel->getBestSellingProducts(5);
        $recentOrders = $this->purchaseModel->getRecentOrders(5);
        
        return [
            'totalSales' => $totalSales,
            'monthSales' => $monthSales,
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'averageOrderValue' => $averageOrderValue,
            'bestSellingProducts' => $bestSellingProducts,
            'recentOrders' => $recentOrders
        ];
    }

    public function show() {
        $stats = $this->getStatistics();
        ob_start();
        ?>
        <main class="flex-1 p-8 bg-gray-50">
            <!-- En-tête du Dashboard -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 font-supreme">Tableau de bord</h1>
                <p class="mt-2 text-gray-600 font-supreme">Vue d'ensemble des performances de votre boutique</p>
            </div>

            <!-- Cartes des statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Ventes totales -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-supreme">Ventes Totales</h3>
                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded-full font-supreme">Annuel</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 font-supreme"><?= number_format($stats['totalSales'], 2) ?> €</p>
                    <div class="mt-2 flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"/>
                        </svg>
                        <span class="font-supreme">+12.5% vs mois dernier</span>
                    </div>
                </div>

                <!-- Ventes du mois -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-supreme">Ventes du Mois</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded-full font-supreme">Mensuel</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 font-supreme"><?= number_format($stats['monthSales'], 2) ?> €</p>
                    <div class="mt-2 flex items-center text-sm text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"/>
                        </svg>
                        <span class="font-supreme">+8.2% vs hier</span>
                    </div>
                </div>

                <!-- Nombre d'utilisateurs -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-supreme">Utilisateurs</h3>
                        <span class="bg-purple-100 text-purple-800 text-xs px-2.5 py-0.5 rounded-full font-supreme">Total</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 font-supreme"><?= $stats['totalUsers'] ?></p>
                    <div class="mt-2 flex items-center text-sm text-purple-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"/>
                        </svg>
                        <span class="font-supreme">+4.5% cette semaine</span>
                    </div>
                </div>

                <!-- Panier moyen -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-gray-500 text-sm font-supreme">Panier Moyen</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-0.5 rounded-full font-supreme">Moyenne</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 font-supreme"><?= number_format($stats['averageOrderValue'], 2) ?> €</p>
                    <div class="mt-2 flex items-center text-sm text-yellow-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"/>
                        </svg>
                        <span class="font-supreme">+2.3% vs mois dernier</span>
                    </div>
                </div>
            </div>

            <!-- Graphiques et tableaux -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Meilleures ventes -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold mb-4 font-supreme">Meilleures Ventes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Produit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Ventes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Revenu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($stats['bestSellingProducts'] as $product): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-supreme"><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-supreme"><?= $product['sales_count'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-supreme"><?= number_format($product['revenue'], 2) ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dernières commandes -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold mb-4 font-supreme">Dernières Commandes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Commande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Montant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-supreme">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($stats['recentOrders'] as $order): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-supreme">#<?= $order['id'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-supreme"><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-supreme"><?= number_format($order['total'], 2) ?> €</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-supreme"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Back Office', "Tableau de bord administrateur", ['backoffice']))->show();
    }
}
?>
