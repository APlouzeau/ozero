<?php
require_once __DIR__ . '/../../utils/functions.php';
class ProductView extends View
{
    public function show($product)
    {
        ob_start();
?>
        <div class="bg-white min-h-screen py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->
                <nav class="flex mb-8 text-sm text-gray-500">
                    <a href="/" class="hover:text-green-600">Accueil</a>
                    <span class="mx-2">/</span>
                    <a href="/catalogue?highlight=<?= $product->getProductId() ?>" class="hover:text-green-600">Catalogue</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium"><?= $product->getProduct() ?></span>
                </nav>

                <!-- Contenu principal -->
                <div class="flex flex-col md:flex-row -mx-4">
                    <!-- Colonne gauche: Images -->
                    <div class="md:flex-1 px-4 mb-8 md:mb-0">
                        <div class="sticky top-6">
                            <div class="rounded-lg overflow-hidden bg-gray-50 mb-4 border border-gray-200">
                                <img src="<?= $product->getImages()[0] ?>" alt="<?= $product->getProduct() ?>" class="w-full h-96 object-contain">
                            </div>
                            
                            <?php if (count($product->getImages()) > 1): ?>
                            <div class="flex -mx-2 mb-4">
                                <?php foreach($product->getImages() as $index => $image): ?>
                                <div class="px-2 w-1/4">
                                    <div class="rounded-md overflow-hidden border-2 <?= $index === 0 ? 'border-green-500' : 'border-gray-200 hover:border-green-300' ?> cursor-pointer">
                                        <img src="<?= $image ?>" alt="<?= $product->getProduct() ?>" class="w-full h-20 object-cover">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Colonne droite: Informations produit -->
                    <div class="md:flex-1 px-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= $product->getProduct() ?></h1>
                        
                        <!-- Évaluations -->
                        <div class="flex items-center mb-6">
                            <div class="flex items-center">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $i < 5 ? 'text-yellow-400' : 'text-gray-300' ?>" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-gray-600 ml-3">(10 avis)</span>
                        </div>
                        
                        <!-- Prix et stock -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <span class="text-3xl font-bold text-gray-900"><?= $product->getPrice() ?> €</span>
                                <?php if ($product->getStock() > 0): ?>
                                <span class="ml-4 px-2.5 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full">En stock</span>
                                <?php else: ?>
                                <span class="ml-4 px-2.5 py-0.5 bg-red-100 text-red-800 text-xs font-medium rounded-full">Rupture de stock</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-sm text-gray-500">
                                <?php if ($product->getStock() > 10): ?>
                                Plus de 10 unités disponibles
                                <?php else: ?>
                                Plus que <?= $product->getStock() ?> en stock!
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <!-- Options d'achat -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="mr-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                                    <div class="custom-number-input h-10 w-32">
                                        <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent">
                                            <button data-action="decrement" class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-200 h-full w-20 rounded-l cursor-pointer outline-none">
                                                <span class="m-auto text-xl font-thin">−</span>
                                            </button>
                                            <input type="number" id="quantity" class="focus:outline-none text-center w-full bg-gray-50 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none" name="quantity" value="1" min="1" max="<?= $product->getStock() ?>">
                                            <button data-action="increment" class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:bg-gray-200 h-full w-20 rounded-r cursor-pointer">
                                                <span class="m-auto text-xl font-thin">+</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bouton d'ajout au panier -->
                            <form action="/panier/add" method="post" class="mb-4">
                                <input type="hidden" name="product[]" value="<?= $product->getProduct() ?>">
                                <input type="hidden" name="price[]" value="<?= $product->getPrice() ?>">
                                <input type="hidden" name="productId[]" value="<?= $product->getProductId() ?>">
                                <input type="hidden" name="quantity[]" id="form-quantity" value="1">
                                <div class="flex space-x-3">
                                    <button type="submit" class="flex-1 min-w-0 bg-green-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                        Ajouter au panier
                                    </button>
                                    <button type="button" class="p-3 rounded-lg bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Description -->
                        <div class="border-t border-gray-200 pt-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
                            <div class="prose prose-green max-w-none">
                                <p class="text-gray-700"><?= htmlspecialchars_decode($product->getDescription()) ?></p>
                            </div>
                        </div>
                        
                        <!-- Livraison -->
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Livraison</h2>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700">Livraison gratuite à partir de 50€ d'achat</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700">Expédition sous 24h pour toute commande passée avant 15h</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700">Retours gratuits pendant 30 jours</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script pour le sélecteur de quantité -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Gestion des boutons d'incrémentation/décrémentation
                const decrementButtons = document.querySelectorAll('[data-action="decrement"]');
                const incrementButtons = document.querySelectorAll('[data-action="increment"]');
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                
                // Stocker l'ID du produit consulté dans le localStorage
                localStorage.setItem('lastViewedProductId', '<?= $product->getProductId() ?>');
                
                // Decrement
                decrementButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = quantityInput;
                        let value = parseInt(target.value);
                        value = isNaN(value) ? 1 : value;
                        value--;
                        if (value < 1) value = 1;
                        target.value = value;
                        formQuantityInput.value = value;
                    });
                });
                
                // Increment
                incrementButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = quantityInput;
                        let value = parseInt(target.value);
                        value = isNaN(value) ? 1 : value;
                        value++;
                        if (value > <?= $product->getStock() ?>) value = <?= $product->getStock() ?>;
                        target.value = value;
                        formQuantityInput.value = value;
                    });
                });
                
                // Mise à jour manuelle
                quantityInput.addEventListener('change', function() {
                    let value = parseInt(this.value);
                    value = isNaN(value) ? 1 : value;
                    if (value < 1) value = 1;
                    if (value > <?= $product->getStock() ?>) value = <?= $product->getStock() ?>;
                    this.value = value;
                    formQuantityInput.value = value;
                });
            });
        </script>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Produit | ' . $product->getProduct(), "Détails du produit " . $product->getProduct(), ['debug']))->show();
    }

    public function showCatalog($products, $categories, $productsByCategorys)
    {
        ob_start();
    ?>
        <div class="bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- En-tête de la page -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Catalogue de produits</h1>
                    <p class="text-gray-600">Découvrez notre sélection d'articles écologiques pour vos projets DIY</p>
                </div>

                <!-- Filtres et Produits -->
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Sidebar de filtres -->
                    <div class="lg:w-1/4">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h2>
                            
                            <!-- Filtre par catégorie -->
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Catégories</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input id="category-all" name="category" type="radio" value="all" class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                                        <label for="category-all" class="ml-2 text-sm text-gray-700">Toutes les catégories</label>
                                    </div>
                                    <?php foreach ($categories as $category) { ?>
                                        <div class="flex items-center">
                                            <input id="category-<?= $category->getCategoryId() ?>" name="category" type="radio" value="<?= $category->getCategoryId() ?>" class="h-4 w-4 text-green-600 focus:ring-green-500 category-filter">
                                            <label for="category-<?= $category->getCategoryId() ?>" class="ml-2 text-sm text-gray-700"><?= $category->getName() ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <!-- Filtre de prix -->
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-900 mb-3">Prix</h3>
                                <div class="mt-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600" id="min-price-display">0 €</span>
                                        <span class="text-sm text-gray-600" id="max-price-display"><?= getMaxPrice($productsByCategorys) ?> €</span>
                                    </div>
                                    <input
                                        type="range"
                                        min="0"
                                        max="<?= getMaxPrice($productsByCategorys) ?>"
                                        value="<?= getMaxPrice($productsByCategorys) ?>"
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600"
                                        id="price-filter"
                                    />
                                    <div class="flex justify-between items-center mt-6">
                                        <div class="relative">
                                            <input type="number" id="price-min" min="0" value="0" 
                                                class="w-24 px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                                focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                            />
                                            <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">€</span>
                                        </div>
                                        <span class="text-gray-500 mx-2">à</span>
                                        <div class="relative">
                                            <input type="number" id="price-max" min="0" value="<?= getMaxPrice($productsByCategorys) ?>" 
                                                class="w-24 px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                                focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                            />
                                            <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bouton d'application des filtres -->
                            <button id="apply-filters" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                Appliquer les filtres
                            </button>
                        </div>
                    </div>

                    <!-- Section des produits -->
                    <div class="lg:w-3/4">
                        <!-- Contrôles de tri et d'affichage -->
                        <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col sm:flex-row justify-between items-center">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <span class="text-gray-700 mr-2">Trier par:</span>
                                <select id="sort-options" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2">
                                    <option value="default">Pertinence</option>
                                    <option value="price-asc">Prix croissant</option>
                                    <option value="price-desc">Prix décroissant</option>
                                    <option value="name-asc">Nom (A-Z)</option>
                                    <option value="name-desc">Nom (Z-A)</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="grid-view" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </button>
                                <button id="list-view" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Grille de produits -->
                        <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($productsByCategorys as $product) { ?>
                                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1" 
                                    data-category="<?= $product['categoryId'] ?>" 
                                    data-price="<?= $product['price'] ?>" 
                                    data-productid="<?= $product['productId'] ?>"
                                    data-name="<?= strtolower($product['product']) ?>">
                                    <div class="relative h-48 bg-gray-200">
                                        <?php if (!empty($product['image_path'])) { ?>
                                            <img src="<?= $product['image_path'] ?>" alt="<?= $product['product'] ?>" class="w-full h-full object-cover">
                                        <?php } else { ?>
                                            <div class="flex items-center justify-center h-full bg-gray-200">
                                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        <?php } ?>
                                        <?php foreach ($categories as $category) { 
                                            if ($category->getCategoryId() == $product['categoryId']) { ?>
                                                <span class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    <?= $category->getName() ?>
                                                </span>
                                        <?php break; } } ?>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= $product['product'] ?></h3>
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?= $product['description'] ?></p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900"><?= $product['price'] ?> €</span>
                                            <div class="flex space-x-2">
                                                <a href="/produit/<?= $product['productId'] ?>" class="inline-flex items-center px-3 py-1.5 border border-green-600 text-xs font-medium rounded text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Détails
                                                </a>
                                                <form action="/panier/add" method="post" class="inline-block">
                                                    <input type="hidden" name="product[]" value="<?= $product['product'] ?>">
                                                    <input type="hidden" name="price[]" value="<?= $product['price'] ?>">
                                                    <input type="hidden" name="productId[]" value="<?= $product['productId'] ?>">
                                                    <input type="hidden" name="quantity[]" value="1">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                                        </svg>
                                                        Ajouter
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Message "Aucun produit trouvé" (caché par défaut) -->
                        <div id="no-products-message" class="hidden bg-white rounded-lg shadow-md p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit ne correspond à vos critères</h3>
                            <p class="text-gray-600 mb-4">Essayez de modifier vos filtres pour voir plus de produits.</p>
                            <button id="reset-filters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script JavaScript pour la fonctionnalité de filtrage et de tri -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const productsContainer = document.getElementById('products-container');
                const noProductsMessage = document.getElementById('no-products-message');
                const priceFilter = document.getElementById('price-filter');
                const priceMinInput = document.getElementById('price-min');
                const priceMaxInput = document.getElementById('price-max');
                const minPriceDisplay = document.getElementById('min-price-display');
                const maxPriceDisplay = document.getElementById('max-price-display');
                const applyFiltersBtn = document.getElementById('apply-filters');
                const resetFiltersBtn = document.getElementById('reset-filters');
                const categoryInputs = document.querySelectorAll('input[name="category"]');
                const sortOptions = document.getElementById('sort-options');
                const gridViewBtn = document.getElementById('grid-view');
                const listViewBtn = document.getElementById('list-view');
                
                let maxPrice = <?= getMaxPrice($productsByCategorys) ?>;
                let currentView = 'grid';
                
                // Mise en évidence du produit précédemment consulté
                function highlightLastViewedProduct() {
                    // Vérifier les paramètres d'URL
                    const urlParams = new URLSearchParams(window.location.search);
                    let productIdToHighlight = urlParams.get('highlight');
                    
                    // Si non présent dans l'URL, vérifier le localStorage
                    if (!productIdToHighlight) {
                        productIdToHighlight = localStorage.getItem('lastViewedProductId');
                    }
                    
                    if (productIdToHighlight) {
                        const productCard = document.querySelector(`.product-card[data-productid="${productIdToHighlight}"]`);
                        if (productCard) {
                            // Ajouter une classe pour la mise en évidence
                            productCard.classList.add('ring-4', 'ring-green-500', 'ring-opacity-70');
                            
                            // Ajouter le libellé "vu à l'instant"
                            const badgeElement = document.createElement('span');
                            badgeElement.className = 'absolute top-2 left-2 bg-green-600 text-white text-xs font-medium px-2.5 py-1 rounded-full shadow-sm';
                            badgeElement.textContent = 'Vu à l\'instant';
                            
                            // Ajouter le badge à la div relative contenant l'image
                            const imageContainer = productCard.querySelector('.relative');
                            if (imageContainer) {
                                imageContainer.appendChild(badgeElement);
                            }
                            
                            // Faire défiler jusqu'au produit après un court délai
                            setTimeout(() => {
                                productCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }, 300);
                        }
                    }
                }
                
                // Mise à jour de l'affichage du prix en fonction du curseur
                priceFilter.addEventListener('input', function() {
                    maxPriceDisplay.textContent = this.value + ' €';
                    priceMaxInput.value = this.value;
                });
                
                // Synchronisation des inputs de prix avec le slider
                priceMinInput.addEventListener('input', function() {
                    const value = parseInt(this.value) || 0;
                    minPriceDisplay.textContent = value + ' €';
                });
                
                priceMaxInput.addEventListener('input', function() {
                    const value = parseInt(this.value) || maxPrice;
                    priceFilter.value = value;
                    maxPriceDisplay.textContent = value + ' €';
                });
                
                // Application des filtres
                applyFiltersBtn.addEventListener('click', filterProducts);
                resetFiltersBtn.addEventListener('click', resetFilters);
                
                // Changement de vue
                gridViewBtn.addEventListener('click', function() {
                    setView('grid');
                });
                
                listViewBtn.addEventListener('click', function() {
                    setView('list');
                });
                
                // Tri des produits
                sortOptions.addEventListener('change', function() {
                    filterProducts();
                });
                
                function filterProducts() {
                    const minPrice = parseInt(priceMinInput.value) || 0;
                    const maxPrice = parseInt(priceMaxInput.value) || <?= getMaxPrice($productsByCategorys) ?>;
                    let selectedCategory = 'all';
                    
                    categoryInputs.forEach(input => {
                        if (input.checked) {
                            selectedCategory = input.value;
                        }
                    });
                    
                    const productCards = document.querySelectorAll('.product-card');
                    let visibleCount = 0;
                    
                    productCards.forEach(card => {
                        const productPrice = parseFloat(card.dataset.price);
                        const productCategory = card.dataset.category;
                        
                        const matchesCategory = selectedCategory === 'all' || productCategory === selectedCategory;
                        const matchesPrice = productPrice >= minPrice && productPrice <= maxPrice;
                        
                        if (matchesCategory && matchesPrice) {
                            card.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                    
                    // Afficher/masquer le message "Aucun produit trouvé"
                    if (visibleCount === 0) {
                        productsContainer.classList.add('hidden');
                        noProductsMessage.classList.remove('hidden');
                    } else {
                        productsContainer.classList.remove('hidden');
                        noProductsMessage.classList.add('hidden');
                        
                        // Appliquer le tri
                        sortProducts();
                    }
                }
                
                function resetFilters() {
                    // Réinitialiser les filtres de catégorie
                    document.getElementById('category-all').checked = true;
                    
                    // Réinitialiser les filtres de prix
                    priceFilter.value = maxPrice;
                    priceMinInput.value = 0;
                    priceMaxInput.value = maxPrice;
                    minPriceDisplay.textContent = '0 €';
                    maxPriceDisplay.textContent = maxPrice + ' €';
                    
                    // Réinitialiser le tri
                    sortOptions.value = 'default';
                    
                    // Appliquer les filtres réinitialisés
                    filterProducts();
                }
                
                function sortProducts() {
                    const sortValue = sortOptions.value;
                    const cards = Array.from(document.querySelectorAll('.product-card:not(.hidden)'));
                    
                    cards.sort((a, b) => {
                        switch (sortValue) {
                            case 'price-asc':
                                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                            case 'price-desc':
                                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                            case 'name-asc':
                                return a.dataset.name.localeCompare(b.dataset.name);
                            case 'name-desc':
                                return b.dataset.name.localeCompare(a.dataset.name);
                            default:
                                return 0; // Pas de tri spécifique
                        }
                    });
                    
                    // Réorganiser les produits selon le tri
                    cards.forEach(card => {
                        productsContainer.appendChild(card);
                    });
                }
                
                function setView(view) {
                    currentView = view;
                    
                    // Réinitialiser toutes les classes de grille du conteneur
                    productsContainer.className = 'grid gap-6';
                    
                    // Réinitialiser les styles des boutons de vue
                    gridViewBtn.className = 'p-2 rounded-md hover:bg-gray-100 focus:outline-none';
                    listViewBtn.className = 'p-2 rounded-md hover:bg-gray-100 focus:outline-none';
                    
                    // Réinitialiser les styles des cartes produit
                    document.querySelectorAll('.product-card').forEach(card => {
                        // Retirer toutes les classes flex et dimensions spécifiques
                        card.className = 'product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1';
                        
                        const imageDiv = card.querySelector('.relative');
                        const contentDiv = card.querySelector('.p-4');
                        
                        if (imageDiv) {
                            imageDiv.className = 'relative h-48 bg-gray-200';
                        }
                        
                        if (contentDiv) {
                            contentDiv.className = 'p-4';
                        }
                    });
                    
                    if (view === 'grid') {
                        // Appliquer le style de grille
                        productsContainer.classList.add('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
                        
                        // Mettre à jour les styles des boutons
                        gridViewBtn.classList.add('bg-green-100', 'text-green-600');
                        listViewBtn.classList.add('text-gray-500');
                    } else {
                        // Appliquer le style de liste
                        productsContainer.classList.add('grid-cols-1');
                        
                        // Mettre à jour les styles des boutons
                        listViewBtn.classList.add('bg-green-100', 'text-green-600');
                        gridViewBtn.classList.add('text-gray-500');
                        
                        // Modifier l'affichage des cartes pour la vue en liste
                        document.querySelectorAll('.product-card').forEach(card => {
                            card.classList.add('md:flex', 'md:flex-row');
                            
                            const imageDiv = card.querySelector('.relative');
                            const contentDiv = card.querySelector('.p-4');
                            
                            if (imageDiv) {
                                imageDiv.className = 'relative h-48 md:h-auto md:w-1/3 bg-gray-200';
                            }
                            
                            if (contentDiv) {
                                contentDiv.className = 'p-4 md:w-2/3';
                            }
                        });
                    }
                }
                
                // Initialiser la vue
                setView('grid');
                
                // Effectuer un filtrage initial pour s'assurer que tout est affiché correctement
                filterProducts();
                
                // Mettre en évidence le dernier produit consulté
                highlightLastViewedProduct();
            });
        </script>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Catalogue', "Catalogue de produits", ['debug', 'catalog']))->show();
    }
}
