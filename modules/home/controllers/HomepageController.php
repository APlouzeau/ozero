<?php

class HomepageController
{

    public function __construct() {}

    /**
     * @return void
     */
    public function execute()
    {

        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();
        $productNumber = 0;
        count($products) < 8 ? $productNumber = count($products) : $productNumber = 8;
        var_dump($products[0]->getImages()[0]);
        $productZero = $products[0]->getImages();
        var_dump($productZero[0]);
        $view = new HomepageView();
        $view->show($products, $productNumber);
    }

    public function blog()
    {
        $view = new ArticlesPageView();
        $view->blogShow();
    }

    public function diy()
    {
        $view = new ArticlesPageView();
        $view->diyShow();
    }
}
