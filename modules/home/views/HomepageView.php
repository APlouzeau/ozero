<?php

class HomepageView extends View
{
    public function show($products, $productNumber)
    {
        ob_start();
?>
        <div class="bg-white min-h-screen">
            <!-- Section: Zéro déchet et Mode de vie -->
            <div class="max-w-6xl mx-auto my-8 md:my-12 px-4">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Colonne 1: Le Zéro déchet -->
                    <div class="bg-white p-6 rounded-lg shadow-lg shadow-black-950 relative">
                        <h2 class="text-xl md:text-2xl font-semibold text-primary mb-4 font-supreme">Le Zéro déchet, qu'est-ce que c'est ?</h2>
                        <div class="flex">
                            <div class="pr-4">
                                <p class="text-sm md:text-base mb-4 font-supreme">
                                    Le zéro déchet est une démarche visant à réduire la production de déchets pour protéger l'environnement.
                                    Elle repose sur la règle des 5R : refuser ce qui est inutile,
                                    réduire sa consommation, réutiliser au maximum, recycler correctement, et composter les déchets organiques.
                                </p>
                                <p class="text-sm md:text-base mb-4 font-supreme">
                                    L'objectif est de limiter le gaspillage universel des ressources et de réduire la pollution. Cette démarche s'applique à des gestes simples comme acheter en vrac, utiliser des contenants réutilisables, etc.
                                    C'est une approche progressive et accessible à tous.
                                </p>
                                <a href="#" class="text-primary font-semibold hover:underline font-supreme">Lire plus</a>
                            </div>
                            <div class="absolute top-6 right-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="Black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne 2: Comment changer notre mode de vie -->
                    <div class="bg-white p-6 rounded-lg shadow-lg shadow-black-950 relative">
                        <h2 class="text-xl md:text-2xl font-semibold text-primary mb-4 font-supreme">Comment changer notre mode de vie ?</h2>
                        <div class="flex">
                            <div class="pr-4">
                                <p class="text-sm md:text-base mb-4 font-supreme">
                                    Le DIY ("Do It Yourself"), ou "faire soi-même", est une alternative écologique qui encourage la création plutôt que la consommation des objets du quotidien pour éviter la surconsommation et limiter les déchets.
                                </p>
                                <p class="text-sm md:text-base mb-4 font-supreme">
                                    Cette démarche encourage une consommation plus responsable, tout en permettant de réaliser des économies significatives. En fabriquant nos propres produits, nous transformons des matériaux existants en ne recourant qu'à des recettes spécifiques de manière personnalisée.
                                </p>
                                <a href="#" class="text-primary font-semibold hover:underline font-supreme">Lire plus</a>
                            </div>
                            <div class="absolute top-6 right-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="Black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 16v-4"></path>
                                    <path d="M12 8h.01"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Notre catalogue -->
            <div class="max-w-6xl mx-auto my-12 px-4">
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="flex items-center">
                        <span class="bg-primary text-white text-xs px-2 py-1 rounded mr-2 font-supreme">Achats éco-responsables</span>
                        <h2 class="text-xl md:text-2xl font-semibold font-supreme">Notre catalogue</h2>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <!-- Produit 1 -->
                    <?php
                    for ($i = 0; $i < $productNumber; $i++) {
                    ?>
                        <div class="overflow-hidden border h-40 border-gray-200 rounded-lg shadow-lg shadow-black-950 relative group">
                            <a href="/produit/<?= $products[$i]->getProductId() ?>">
                                <img src="<?= $products[$i]->getImages()[0] ?>" alt="<?= $products[$i]->getProduct() ?>" class="object-cover w-full h-full">
                                <!-- Overlay avec les détails du produit -->
                                <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <h3 class="font-semibold text-sm md:text-base font-supreme truncate text-white"><?= $products[$i]->getProduct() ?></h3>
                                    <p class="text-xs md:text-sm font-supreme line-clamp-2 my-1 text-white"><?= $products[$i]->getDescription() ?></p>
                                    <p class="font-bold text-sm md:text-base font-supreme text-white"><?= $products[$i]->getPrice() ?> €</p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    <!-- Produit 2 -->
                    <!-- <div class="bg-white rounded-lg shadow-lg shadow-black-950 overflow-hidden">
                        <div class="h-40 bg-gray-200"></div>
                    </div> -->
                </div>
            </div>

            <!-- Section: Articles en promotions -->
            <div class="max-w-6xl mx-auto my-12 px-4">
                <h2 class="text-xl md:text-2xl font-semibold mb-6 text-center font-supreme">Articles en promotions</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    // Utiliser des produits différents de ceux déjà affichés dans le catalogue
                    // On commence à l'index après le dernier produit affiché dans le catalogue
                    $startIndex = $productNumber;
                    $remainingProducts = count($products) - $startIndex;
                    $promoCount = min($remainingProducts, 4);

                    // Promotions en dur
                    $promotions = [15, 20, 25, 30];

                    for ($i = 0; $i < $promoCount; $i++) {
                        $productIndex = $startIndex + $i;
                        if ($productIndex < count($products)) {
                            $product = $products[$productIndex];
                            $promotion = $promotions[$i % count($promotions)];
                            $originalPrice = $product->getPrice();
                            $promoPrice = $originalPrice * (1 - $promotion / 100);
                    ?>
                            <div class="overflow-hidden border h-40 border-gray-200 rounded-lg shadow-lg shadow-black-950 relative group">
                                <a href="/produit/<?= $product->getProductId() ?>">
                                    <img src="<?= $product->getImages()[0] ?>" alt="<?= $product->getProduct() ?>" class="object-cover w-full h-full">
                                    <!-- Badge promotion -->
                                    <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                                        -<?= $promotion ?>%
                                    </div>
                                    <!-- Overlay avec les détails du produit -->
                                    <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <h3 class="font-semibold text-sm md:text-base font-supreme truncate text-white"><?= $product->getProduct() ?></h3>
                                        <p class="text-xs md:text-sm font-supreme line-clamp-2 my-1 text-white"><?= $product->getDescription() ?></p>
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-supreme line-through text-white opacity-70"><?= number_format($originalPrice, 2) ?> €</p>
                                            <p class="font-bold text-sm md:text-base font-supreme text-red-600"><?= number_format($promoPrice, 2) ?> €</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                    }

                    // Si on n'a pas assez de produits, on affiche des placeholders
                    for ($i = $promoCount; $i < 4; $i++) {
                        $randomPromo = rand(10, 50);
                        $originalPrice = rand(15, 50);
                        $promoPrice = $originalPrice * (1 - $randomPromo / 100);
                        ?>
                        <div class="bg-white rounded-lg shadow-lg shadow-black-950 overflow-hidden relative group">
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <!-- Image placeholder -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <!-- Badge promotion -->
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                                -<?= $randomPromo ?>%
                            </div>
                            <!-- Overlay avec les détails du produit -->
                            <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <h3 class="font-semibold text-sm md:text-base font-supreme truncate text-white">Produit bientôt en promotion</h3>
                                <p class="text-xs md:text-sm font-supreme line-clamp-2 my-1 text-white">Ce produit sera bientôt disponible avec une promotion exceptionnelle.</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-supreme line-through text-white opacity-70"><?= number_format($originalPrice, 2) ?> €</p>
                                    <p class="font-bold text-sm md:text-base font-supreme text-red-600"><?= number_format($promoPrice, 2) ?> €</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Section: Et ça change quoi ? -->
            <div class="max-w-6xl mx-auto my-12 px-4 pb-12">
                <h2 class="text-xl md:text-2xl font-semibold mb-8 text-center text-primary font-supreme">Et ça change quoi ?</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Statistique 1 -->
                    <div class="flex flex-col items-center">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="Black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl md:text-3xl font-bold text-primary font-supreme">12 KgCO2</h3>
                            <p class="text-sm md:text-base mt-2 font-supreme">Ce sont les émissions de gaz à effet de serre évitées en adoptant une démarche zéro déchets</p>
                        </div>
                    </div>

                    <!-- Statistique 2 -->
                    <div class="flex flex-col items-center">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="Black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl md:text-3xl font-bold text-primary font-supreme">142 Kg</h3>
                            <p class="text-sm md:text-base mt-2 font-supreme">Quantité de déchets de nos produits</p>
                        </div>
                    </div>

                    <!-- Statistique 3 -->
                    <div class="flex flex-col items-center">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="Black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"></path>
                                <path d="M12 7v8"></path>
                                <path d="M8 9l4-2 4 2"></path>
                                <path d="M8 17l4 2 4-2"></path>
                                <path d="M8 13h8"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl md:text-3xl font-bold text-primary font-supreme">110</h3>
                            <p class="text-sm md:text-base mt-2 font-supreme">C'est le nombre de bouteilles d'eau consommées chaque année en France, dont seulement 10% sont recyclées. Grâce à nous, c'est 110 de moins cette année</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Accueil', "Ceci est la page d'accueil", ['debug']))->show();
    }
}
?>