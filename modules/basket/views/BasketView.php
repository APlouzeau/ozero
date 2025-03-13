<?php

class BasketView extends View
{
    private function getImageUrl($imagePath)
    {
        // Image par défaut si pas d'image
        if (empty($imagePath)) {
            return '/assets/images/default-product.png';
        }

        // Nettoyage de l'URL
        $imagePath = trim($imagePath);
        
        // Cas 1: URL complète (http/https)
        if (preg_match('/^https?:\/\//i', $imagePath)) {
            return $imagePath;
        }
        
        // Cas 2: URL relative commençant par //
        if (strpos($imagePath, '//') === 0) {
            return 'https:' . $imagePath;
        }
        
        // Cas 3: Chemin local commençant par /
        if (strpos($imagePath, '/') === 0) {
            return $imagePath;
        }
        
        // Cas 4: Chemin local sans / initial
        if (!empty($imagePath)) {
            return '/' . $imagePath;
        }
        
        // Par défaut, retourner l'image par défaut
        return '/assets/images/default-product.png';
    }

    private function getCartItemImage($cart)
    {
        // Cas 1: Vérifier 'images' (tableau)
        if (isset($cart['images']) && is_array($cart['images']) && !empty($cart['images'])) {
            return $cart['images'][0];
        }
        
        // Cas 2: Vérifier 'images' (chaîne)
        if (isset($cart['images']) && is_string($cart['images']) && !empty($cart['images'])) {
            return $cart['images'];
        }
        
        // Cas 3: Vérifier 'image' (chaîne)
        if (isset($cart['image']) && !empty($cart['image'])) {
            return $cart['image'];
        }
        
        return '';
    }

    public function show()
    {
        ob_start();
        $totalAmount = 0;
?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Votre Panier</h1>
            
            <?php if (empty($_SESSION['cart'])) : ?>
                <div class="text-center py-12">
                    <p class="text-gray-500 text-xl">Votre panier est vide</p>
                    <a href="/" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-focus">
                        Continuer vos achats
                    </a>
                </div>
            <?php else : ?>
                <form action="/panier/checkConnect" method="post" class="space-y-8">
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 hidden md:table-header-group">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($_SESSION['cart'] as $cart) : 
                                    $imageUrl = $this->getImageUrl($this->getCartItemImage($cart));
                                ?>
                                    <tr class="hover:bg-gray-50 transition-colors flex flex-col md:table-row">
                                        <td class="px-6 py-4 flex items-center md:table-cell">
                                            <div class="flex items-center w-full md:w-auto">
                                                <div class="relative h-24 w-24 md:h-20 md:w-20 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden group">
                                                    <img 
                                                        class="h-full w-full object-cover transition-opacity duration-300" 
                                                        src="<?= htmlspecialchars($imageUrl) ?>" 
                                                        alt="<?= htmlspecialchars($cart['product']) ?>"
                                                        onerror="this.onerror=null; this.src='/assets/images/default-product.png';"
                                                    >
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity duration-300"></div>
                                                </div>
                                                <div class="ml-4 flex-1 md:hidden">
                                                    <div class="text-base font-medium text-gray-900"><?= htmlspecialchars($cart['product']) ?></div>
                                                    <div class="mt-1 text-sm text-gray-500"><?= number_format($cart['price'], 2) ?> €</div>
                                                    <div class="mt-2 text-sm text-gray-500">
                                                        Quantité : <span class="font-medium text-gray-900"><?= $cart['quantity'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden md:table-cell px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($cart['product']) ?></div>
                                            <input type="hidden" class="product" name="product" value="<?= htmlspecialchars($cart['product']) ?>">
                                            <input type="hidden" class="productId" name="productId" value="<?= $cart['productId'] ?>">
                                        </td>
                                        <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?= number_format($cart['price'], 2) ?> €</div>
                                            <input type="hidden" class="price" name="price" value="<?= $cart['price'] ?>">
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap">
                                            <div class="flex items-center justify-end md:justify-start space-x-3">
                                                <button type="button" class="remove-one inline-flex items-center p-2 border border-gray-300 rounded-full shadow-sm text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                                <span class="quantityShow text-base font-medium text-gray-900 min-w-[1.5rem] text-center"><?= $cart['quantity'] ?></span>
                                                <input type="hidden" class="quantity" name="quantity" value="<?= $cart['quantity'] ?>">
                                                <button type="button" class="add-one inline-flex items-center p-2 border border-gray-300 rounded-full shadow-sm text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                $totalAmount += $cart['price'] * $cart['quantity'];
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white px-4 sm:px-6 py-6 sm:py-8 rounded-lg shadow-lg border border-gray-100">
                        <div class="flex flex-col space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <div class="text-lg text-gray-600">Sous-total</div>
                                <div class="text-lg font-medium text-gray-900"><?= number_format($totalAmount, 2) ?> €</div>
                            </div>
                            <div class="flex justify-between items-center pb-4">
                                <div class="text-xl font-semibold text-gray-900">Total TTC</div>
                                <div class="text-2xl font-bold text-primary"><?= number_format($totalAmount, 2) ?> €</div>
                                <input type="hidden" name="totalAmount" id="totalAmount" value="<?= $totalAmount ?>">
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 sm:px-8 py-3 sm:py-4 border border-transparent rounded-lg text-base sm:text-lg font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200 ease-in-out">
                                    <span>Procéder au paiement</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Panier', "Votre panier", ['debug', 'basket']))->show();
    }

    public function shipping($user, $addresse)
    {
        ob_start();
    ?>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Adresse de livraison</h1>
            
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <form action="/panier/confirmation" method="post" class="p-6 space-y-6">
                    <input type="hidden" name="userId" id="edit-address-user-id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Adresse -->
                        <div class="col-span-2">
                            <label for="edit-street" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse complète
                            </label>
                            <input 
                                type="text" 
                                name="street" 
                                id="edit-street" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-colors" 
                                value="<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getStreet() ?? '') : '' ?>"
                                required
                            >
                        </div>

                        <!-- Code postal -->
                        <div>
                            <label for="edit-zipCode" class="block text-sm font-medium text-gray-700 mb-2">
                                Code postal
                            </label>
                            <input 
                                type="text" 
                                name="zipCode" 
                                id="edit-zipCode" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-colors" 
                                value="<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getZipCode() ?? '') : '' ?>"
                                required
                            >
                        </div>

                        <!-- Ville -->
                        <div>
                            <label for="edit-city" class="block text-sm font-medium text-gray-700 mb-2">
                                Ville
                            </label>
                            <input 
                                type="text" 
                                name="city" 
                                id="edit-city" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-colors" 
                                value="<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getCity() ?? '') : '' ?>"
                                required
                            >
                        </div>

                        <!-- Pays -->
                        <div>
                            <label for="edit-country" class="block text-sm font-medium text-gray-700 mb-2">
                                Pays
                            </label>
                            <input 
                                type="text" 
                                name="country" 
                                id="edit-country" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-colors" 
                                value="<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getCountry() ?? '') : '' ?>"
                                required
                            >
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label for="edit-phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="edit-phone" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-colors" 
                                value="<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getPhone() ?? '') : '' ?>"
                                required
                            >
                        </div>
                    </div>

                    <!-- Résumé de la commande -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Résumé de la commande</h2>
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Total TTC</span>
                            <span class="text-lg font-bold text-primary"><?= number_format($_SESSION['totalAmount'], 2) ?> €</span>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-8 flex flex-col sm:flex-row-reverse gap-4">
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center"
                        >
                            <span>Continuer vers le paiement</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <a 
                            href="/panier" 
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors text-center"
                        >
                            Retour au panier
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Livraison', "Adresse de livraison", ['debug']))->show();
    }

    public function confirmationPage()
    {
        ob_start();
        $totalAmount = 0;
    ?>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Confirmation de commande</h1>

            <!-- Récapitulatif des produits -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Récapitulatif de votre commande</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    <?php foreach ($_SESSION['cart'] as $cart) : 
                        $imageUrl = $this->getImageUrl($this->getCartItemImage($cart));
                        $totalAmount += $cart['price'] * $cart['quantity'];
                    ?>
                        <div class="p-6 flex items-center space-x-6">
                            <div class="relative h-20 w-20 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden">
                                <img 
                                    class="h-full w-full object-cover" 
                                    src="<?= htmlspecialchars($imageUrl) ?>" 
                                    alt="<?= htmlspecialchars($cart['product']) ?>"
                                    onerror="this.onerror=null; this.src='/assets/images/default-product.png';"
                                >
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    <?= htmlspecialchars($cart['product']) ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Quantité : <?= $cart['quantity'] ?>
                                </p>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                <?= number_format($cart['price'], 2) ?> €
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Adresse de livraison -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Adresse de livraison</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <p class="text-sm text-gray-900"><?= htmlspecialchars($_SESSION['addresse']['street']) ?></p>
                        <p class="text-sm text-gray-900">
                            <?= htmlspecialchars($_SESSION['addresse']['zipCode']) ?> <?= htmlspecialchars($_SESSION['addresse']['city']) ?>
                        </p>
                        <p class="text-sm text-gray-900"><?= htmlspecialchars($_SESSION['addresse']['country']) ?></p>
                        <p class="text-sm text-gray-900">Tél : <?= htmlspecialchars($_SESSION['addresse']['phone']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Résumé des coûts -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div class="text-sm text-gray-600">Sous-total</div>
                        <div class="text-sm font-medium text-gray-900"><?= number_format($totalAmount, 2) ?> €</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-base font-semibold text-gray-900">Total TTC</div>
                        <div class="text-xl font-bold text-primary"><?= number_format($totalAmount, 2) ?> €</div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row-reverse gap-4">
                <form action="/panier/confirmationBeforePayment" method="post" class="flex-1">
                    <button type="submit" class="w-full px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center">
                        <span>Confirmer et payer</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
                <a 
                    href="/panier" 
                    class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors text-center"
                >
                    Modifier le panier
                </a>
            </div>
        </div>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Confirmation', "Confirmation de la commande", ['debug']))->show();
    }
}
