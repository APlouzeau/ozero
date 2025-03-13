<?php

class ProductView extends View
{
    public function show($product)
    {
        ob_start();
?>
        <div>
            <h1 class="text-5xl font-bold text-center">Fiche produit</h1>
            <div class="flex justify-center">
                <!-- image du produit -->
                <img src="<?= $product->getImages()[0] ?>" alt="<?= $product->getProduct() ?>" class="w-80 mx-auto">
                <p class="text-center"><?= $product->getDescription() ?></p>

                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title
                text-2xl font-bold text-center"><?= $product->getProduct() ?></h2>
                        <p class="text-center"><?= $product->getPrice() ?> €</p>
                        <p class="text-center"><?= $product->getStock() ?> en stock</p>

                        <div class="card-actions justify-center">
                            <form action="/panier/add" method="post">
                                <input type="hidden" name="product[]" value="<?= $product->getProduct() ?>">
                                <input type="hidden" name="price[]" value="<?= $product->getPrice() ?>">
                                <input type="hidden" name="productId[]" value="<?= $product->getProductId() ?>">
                                <input type="hidden" name="quantity[]" value="1">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Panier', "Votre panier", ['debug',]))->show();
    }

    public function showCatalog($products, $categories, $productsByCategorys)
    {
        ob_start(); ?>

        <div class="bg-white min-h-screen">
            <!-- Section: Qu'est-ce que le DIY -->
            <div class="max-w-6xl mx-auto my-8 md:my-12 px-4">
                <h1 class="text-2xl md:text-3xl font-semibold text-primary mb-6 text-center font-supreme">Nos produits</h1>

                <div class="bg-white p-6 rounded-lg shadow-lg shadow-black-950 mb-12">
                    <div class="max-w-3xl mx-auto">
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Ici, nous demandons à notre ami <span class="font-bold text-primary">Claude</span> (conçus pour nous aider à fabriquer vos propres articles écologiques), de nous générer un <span class="font-bold">beau texte qui vous forcera à nous filer vos thunes</span>.
                        </p>
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Nos coffrets sont conçus pour vous faire cracher un max de <span class="font-bold">fric</span>, tout en privilégiant des matériaux <span class="font-bold">durables et respectueux</span> de l'environnement. Ces articles sont extrêmement léger, ils ne contiennent presque rien, afin de limiter l'impact environnemental lorsque vous vous rendrez compte qu'ils ne vous servent à rien et que vous les balancerez sans vergogne à la poubelle </p>
                    </div>
                </div>
            </div>

            <!-- Section: Catégories -->
            <div class="max-w-6xl mx-auto my-8 px-4">
                <div class="relative mb-2">
                    <h2 class="text-xl md:text-2xl font-semibold text-center mb-4 font-supreme">Catégories</h2>
                    <div class="text-center mb-8">
                        <a href="?category=all" class="inline-block bg-primary text-white px-4 py-2 rounded-lg font-supreme font-semibold hover:bg-primary/80 transition-colors">
                            Voir toutes les catégories
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <?php
                    foreach ($categories as $key => $categorie) { ?>
                        <a href="?category=<?= $key ?>" class="bg-white p-4 rounded-lg shadow-box text-center hover:shadow-lg transition-shadow">
                            <div class="h-32 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                                <!-- Placeholder pour l'image de catégorie -->
                            </div>
                            <h3 class="font-semibold font-supreme"><?= $categorie->getName() ?></h3>
                        </a>
                    <?php }; ?>
                </div>
            </div>

            <?php
            $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
            $viewMode = isset($_GET['view']) ? $_GET['view'] : 'grid';

            // Filtrer les produits par catégorie
            $filteredProducts = array_filter($productsByCategorys, function ($product) use ($selectedCategory) {
                return $selectedCategory === 'all' || $product['categoryId'] === $selectedCategory;
            });
            ?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl md:text-2xl font-semibold font-supreme">
                    <?php
                    $selectedCategory === 'all' ? 'Tous les Produits' : $categories[$selectedCategory];
                    ?>
                </h2>
                <div class="flex items-center">
                    <span class="mr-2 font-supreme">Trier les produits :</span>
                    <div class="flex space-x-2">
                        <a href="?category=<?= $selectedCategory ?>&view=grid" class="<?= (!isset($_GET['view']) || $_GET['view'] === 'grid') ? 'bg-gray-200' : '' ?> p-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </a>
                        <a href="?category=<?= $selectedCategory ?>&view=list" class="<?= (isset($_GET['view']) && $_GET['view'] === 'list') ? 'bg-gray-200' : '' ?> p-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

            <?php if ($viewMode === 'grid'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                    <?php
                    foreach ($productsByCategorys as $product) {
                        if ($product['categoryId'] == $selectedCategory) {
                    ?>
                            <div class="bg-white rounded-lg shadow-box overflow-hidden flex mb-4">
                                <div class="w-1/6 bg-gray-200">
                                    <?php if (!empty($product['image_path'])) { ?>
                                        <img src="<?= $product['image_path'] ?>" alt="<?= $product['product'] ?>" class="w-full h-full object-cover">
                                    <?php } ?>
                                </div>
                                <div class="w-4/6 p-4">
                                    <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $product['product'] ?></h3>
                                    <p class="text-sm text-gray-600 font-supreme"><?= $product['description'] ?></p>
                                </div>
                                <a href="/produit/<?= $product['productId'] ?>" class="btn btn-primary">Lire plus</a>
                            </div>
                    <?php }
                    }; ?>
                </div>
            <?php else: ?>
                <div class="mb-12">

                </div>
            <?php endif; ?>
        </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Panier', "Votre panier", ['debug',]))->show();
    }
}
