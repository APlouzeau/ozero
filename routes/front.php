<?php

// Front Office
$router->addRoute('GET', '/',  'HomepageController#execute');
$router->addRoute('GET', '/diy',  'DiyController#index');
$router->addRoute('GET', '/blog',  'ArticleController#showBlog');
$router->addRoute('GET', '/articles/{id}',  'ArticleController#execute');
$router->addRoute('GET', '/login',  'AuthController#showLoginForm', '');
$router->addRoute('GET', '/register',  'AuthController#showRegisterForm', '');
$router->addRoute('GET', '/profile',  'UserController#Profile', '');


// BackOffice
$router->addRoute('GET', '/admin',  'BackOfficeController#execute');
$router->addRoute('GET', '/admin/users',  'BackUserController#execute');
$router->addRoute('GET', '/admin/users/{id}', 'BackUserEditProfileController#execute',);
$router->addRoute('GET', '/admin/categories',  'BackCategoryController#execute');
$router->addRoute('GET', '/admin/products',  'BackProductController#execute');
$router->addRoute('GET', '/admin/articles',  'BackArticleController#execute');
$router->addRoute('GET', '/admin/articles/create',  'BackArticleController#create');
$router->addRoute('GET', '/admin/articles/edit/{id}',  'BackArticleController#create');
$router->addRoute('GET', '/admin/commandes',  'BackOrderController#showAllOrders');

//Basket
$router->addRoute('GET', '/panier',  'BasketController#execute');
$router->addRoute('GET', '/test-panier',  'BasketController#testPanier');
$router->addRoute('GET', '/panier/livraison',  'BasketController#shippin');

//dashboard
$router->addRoute('GET', '/liste-des-utilisateurs',  'DashboardController#userList');

//Commandes
$router->addRoute('GET', '/commandes', 'UserController#getOrders');
$router->addRoute('GET', '/commandes/{purchaseId}', 'UserController#getOrderDetails', 'AuthMiddleware');

//Products
$router->addRoute('GET', '/produit/{id}',  'ProductController#showProduct');
