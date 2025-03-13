<?php
/**
 * Récupère le prix maximum parmi tous les produits
 * @param array $products Tableau des produits
 * @return int Prix maximum
 */
function getMaxPrice($products) {
    $maxPrice = 0;
    foreach ($products as $product) {
        if (isset($product['price']) && $product['price'] > $maxPrice) {
            $maxPrice = $product['price'];
        }
    }
    return $maxPrice;
}
