<?php

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
                        <img src="<?= $product->getImages()[0] || NULL ?>" alt="<?= $product->getProduct() ?>" class="w-80 h-80 mx-auto">
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
}
