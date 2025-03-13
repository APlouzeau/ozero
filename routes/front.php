<?php

// Front Office
$router->addRoute('GET', '/',  'HomepageController#execute');
$router->addRoute('GET', '/diy',  'ArticleController#showDiy');
$router->addRoute('GET', '/blog',  'ArticleController#showBlog');
$router->addRoute('GET', '/articles/{id}',  'ArticleController#execute');
$router->addRoute('GET', '/products/search',  'ProductController#getAllProducts');
$router->addRoute('GET', '/login',  'AuthController#showLoginForm', '');
$router->addRoute('GET', '/register',  'AuthController#showRegisterForm', '');
$router->addRoute('GET', '/profile',  'UserController#Profile', 'AuthMiddleware');
$router->addRoute('GET', '/catalogue',  'ProductController#showCatalog', '');


// BackOffice
$router->addRoute('GET', '/admin',  'BackOfficeController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/users',  'BackUserController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/users/{id}', 'BackUserEditProfileController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/categories',  'BackCategoryController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/products',  'BackProductController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/articles',  'BackArticleController#execute', 'RoleMiddleware');
$router->addRoute('GET', '/admin/articles/create',  'BackArticleController#create', 'RoleMiddleware');
$router->addRoute('GET', '/admin/articles/edit/{id}',  'BackArticleController#edit', 'RoleMiddleware');
$router->addRoute('GET', '/admin/commandes',  'BackOrderController#showAllOrders', 'RoleMiddleware');
$router->addRoute('GET', '/admin/commandes/{id}',  'BackOrderController#showOrderDetail', 'RoleMiddleware');

//Basket
$router->addRoute('GET', '/panier',  'BasketController#execute');
$router->addRoute('GET', '/test-panier',  'BasketController#testPanier');
$router->addRoute('GET', '/panier/livraison',  'BasketController#shippin');

//dashboard
$router->addRoute('GET', '/liste-des-utilisateurs',  'DashboardController#userList');

//Commandes
$router->addRoute('GET', '/commandes', 'UserController#getOrders');
$router->addRoute('GET', '/commandes/{purchaseId}', 'UserController#getOrderDetails', 'AuthMiddleware');
$router->addRoute('GET', '/order/details/{purchaseId}', 'UserController#getOrderDetails', 'AuthMiddleware');

//Products
$router->addRoute('GET', '/produit/{id}',  'ProductController#showProduct');

//Checkout
$router->addRoute('GET', '/panier/checkoutsession', 'CheckoutController#getCheckoutSession');
$router->addRoute('GET', '/panier/checkoutsessionsuccess', 'CheckoutController#getCheckoutSuccess');