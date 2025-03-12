<?php
function getMaxPrice(array $products)
{
    $prices = [];
    foreach ($products as $product) {
        $prices[] = $product['price'];
    }
    return !empty($prices) ? max($prices) : 0;
}
