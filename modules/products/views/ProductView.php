<?php
require_once __DIR__ . '/../../utils/functions.php';
class ProductView extends View
{
    public function show($product)
    {
        ob_start();
?>
        <div>
            <h1 class="text-5xl font-bold text-center">Produit</h1>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title
                text-2xl font-bold text-center"><?= $product->getProduct() ?></h2>
                        <p class="text-center"><?= $product->getDescription() ?></p>
                        <p class="text-center"><?= $product->getPrice() ?> €</p>
                        <p class="text-center"><?= $product->getStock() ?> en stock</p>

                        <img src="<?= $product->getImages()[0] ?>" alt="<?= $product->getProduct() ?>" class="w-80 h-80 mx-auto">
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
                    
                    // Réinitialiser toutes les classes avant d'appliquer la vue spécifique
                    productsContainer.classList.remove('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
                    
                    // Réinitialiser les styles des boutons
                    gridViewBtn.classList.remove('bg-green-100', 'text-green-600', 'text-gray-500');
                    listViewBtn.classList.remove('bg-green-100', 'text-green-600', 'text-gray-500');
                    
                    // Réinitialiser les styles des cartes produit
                    document.querySelectorAll('.product-card').forEach(card => {
                        card.classList.remove('flex', 'flex-col', 'md:flex-row');
                        const imageDiv = card.querySelector('.relative');
                        const contentDiv = card.querySelector('.p-4');
                        
                        if (imageDiv && contentDiv) {
                            imageDiv.classList.remove('md:w-1/3');
                            contentDiv.classList.remove('md:w-2/3');
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
                            card.classList.add('flex', 'flex-col', 'md:flex-row');
                            const imageDiv = card.querySelector('.relative');
                            const contentDiv = card.querySelector('.p-4');
                            
                            if (imageDiv && contentDiv) {
                                imageDiv.classList.add('md:w-1/3');
                                contentDiv.classList.add('md:w-2/3');
                            }
                        });
                    }
                }
                
                // Initialiser la vue
                setView('grid');
                
                // Effectuer un filtrage initial pour s'assurer que tout est affiché correctement
                filterProducts();
            });
        </script>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Catalogue', "Catalogue de produits", ['debug', 'catalog']))->show();
    }
}
