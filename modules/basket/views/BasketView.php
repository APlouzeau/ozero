<?php

class BasketView extends View
{
    public function show()
    {
        ob_start();
        $totalAmount = 0;
?>
        <h1 class="text-5xl font-bold text-center">Panier</h1>
        <form action="/panier/checkConnect" method="post">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $cart) { ?>
                            <tr>
                                <th>
                                    <label>
                                        <?= $cart['image'] ?>
                                        <input type="hidden" name="product" value=<?= $cart['image'] ?>>
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <?= $cart['product'] ?>
                                        <input type="hidden" class="product" name="product" value="<?= $cart['product'] ?>">
                                        <input type="hidden" class="productId" name="productId" value="<?= $cart['productId'] ?>">
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <?= $cart['price'] ?> €
                                        <input type="hidden" class="price" name="price" value="<?= $cart['price'] ?>">
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <div class="flex">
                                            <img src="/assets/png/plus.png" width="20" height="15" alt="ajouter un produit" class="add-one">
                                            <p class="quantityShow"><?= $cart['quantity'] ?></p>
                                            <input type="hidden" class="quantity" name="quantity" value="<?= $cart['quantity'] ?>">
                                            <img src="/assets/png/moins.png" width="20" height="15" alt="retirer un produit" class="remove-one">
                                        </div>
                                    </label>
                                </th>
                            </tr>
                        <?php }
                        foreach ($_SESSION['cart'] as $cart) {
                            $totalAmount += $cart['price'] * $cart['quantity'];
                        } ?>
                </table>
            </div>
            <div class="text-center">
                <p class="text-2xl">
                    Total : <?= $totalAmount ?> €
                    <input type="hidden" name="totalAmount" id="totalAmount" value=<?= $totalAmount ?>>
                </p>
                <button type="submit" class="my-5 btn btn-accent">Commander</button>
            </div>
        </form>
        </div>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Panier', "Votre panier", ['debug', 'basket']))->show();
    }

    public function shipping($user, $addresse)
    {
        ob_start();
    ?>
        <h1 class="text-5xl font-bold text-center">Page de livraison</h1>
        <form action="/panier/confirmation" method="post">
            <input type="hidden" name="userId" id="edit-address-user-id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Adresse</span>
                    </label>
                    <input type="text" name="street" id="edit-street" class="input input-bordered" value="<?= $addresse instanceof AddressesEntity ? $addresse->getStreet() ?? '' : '' ?>">
                </div>

                <div class=" form-control">
                    <label class="label">
                        <span class="label-text">Code postal</span>
                    </label>
                    <input required type="text" name="zipCode" id="edit-zipCode" class="input input-bordered" value=<?= $addresse instanceof AddressesEntity ? $addresse->getZipCode() ?? '' : '' ?>>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Ville</span>
                    </label>
                    <input required type="text" name="city" id="edit-city" class="input input-bordered" value=<?= $addresse instanceof AddressesEntity ? $addresse->getCity() ?? '' : '' ?>>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Pays</span>
                    </label>
                    <input required type="text" name="country" id="edit-country" class="input input-bordered" value=<?= $addresse instanceof AddressesEntity ? $addresse->getCountry() ?? '' : '' ?>>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Téléphone</span>
                    </label>
                    <input type="text" name="phone" id="edit-phone" class="input input-bordered" value=<?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getPhone() ?? '') : '' ?>>
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <label for="edit-address-modal" class="btn">Annuler</label>
                </div>
            </div>
        </form>


    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Livraison', "Adresse de livraison", ['debug']))->show();
    }

    public function confirmationPage()
    {
        ob_start();
    ?>
        <h1 class="text-5xl font-bold text-center">Page de confirmation</h1>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $cart) { ?>
                    <tr>
                        <th>
                            <label>
                                <?= $cart['image'] ?>
                                <input type="hidden" name="product" value=<?= $cart['image'] ?>>
                            </label>
                        </th>
                        <th>
                            <label>
                                <?= $cart['product'] ?>
                                <input type="hidden" name="product" value=<?= $cart['product'] ?>>
                            </label>
                        </th>
                        <th>
                            <label>
                                <?= $cart['price'] ?> €
                                <input type="hidden" name="price" value=<?= $cart['price'] ?>>
                            </label>
                        </th>
                        <th>
                            <label>
                                <div class="flex">
                                    <img src="/assets/png/plus.png" width="20" height="15" alt="ajouter un produit">
                                    <?= $cart['quantity'] ?>
                                    <input type="hidden" name="quantity" value=<?= $cart['quantity'] ?>>
                                    <img src="/assets/png/moins.png" width="20" height="15" alt="retirer un produit">
                                </div>
                            </label>
                        </th>
                    </tr>
                <?php } ?>
        </table>

        <div class="flex flex-col justify-center">
            <p><?= $_SESSION['addresse']['street'] ?></p>
            <p><?= $_SESSION['addresse']['city'] ?></p>
            <p><?= $_SESSION['addresse']['zipCode'] ?></p>
            <p><?= $_SESSION['addresse']['country'] ?></p>
            <p><?= $_SESSION['addresse']['phone'] ?></p>
        </div>
        <form action="/panier/confirmationBeforePayment" method="post">

            <button type="submit" class="btn">Commander</button>
        </form>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Confirmation', "Confirmation de la commande", ['debug']))->show();
    }
}
