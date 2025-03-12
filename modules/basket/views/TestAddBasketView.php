<?php

class TestAddBasketView extends View
{
    public function show($productList)
    {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Test d'ajout au panier</h1>
                    <form id="add-basket-form" method="post" action="/panier/add">
                        <div>

                            <div class="item">
                                <div class="form-group">
                                    <label for="product"><?= $productList[0]->getProduct() ?></label>
                                    <input type="hidden" class="form-control" name="productId[]" value="<?= $productList[0]->getProductId() ?>">
                                    <input type="hidden" class="form-control" name="product[]" value="<?= $productList[0]->getProduct() ?>">
                                </div>
                                <div class="form-group">
                                    <label for="price"><?= $productList[0]->getPrice() ?></label>
                                    <input type="hidden" class="form-control" id="price0" name="price[]" value="<?= $productList[0]->getPrice() ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity0" name="quantity[]" required>
                                </div>
                            </div>
                           
                        </div>


                        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
<?php
    }
}
