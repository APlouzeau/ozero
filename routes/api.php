<?php

$router->addRoute('POST', '/login', 'AuthController#login');
$router->addRoute('POST', '/register', 'AuthController#register');
$router->addRoute('POST', '/logout', 'AuthController#logout');

// Contact
$router->addRoute('POST', '/api/contact', 'ContactController#sendEmail');

// -- Avec permissions et connecté

// Produits
$router->addRoute('POST', '/admin/products/add', 'ProductController#addProduct', 'RoleMiddleware');
$router->addRoute('POST', '/admin/products/delete', 'ProductController#deleteProduct', 'RoleMiddleware');
$router->addRoute('POST', '/admin/products/update', 'ProductController#updateProduct', 'RoleMiddleware');
$router->addRoute('POST', '/admin/products/deleteimage', 'ProductController#deleteImage', 'RoleMiddleware');

//Catégories
$router->addRoute('POST', '/admin/categories/add', 'BackCategoryController#addCategory', 'RoleMiddleware');
$router->addRoute('POST', '/admin/categories/delete', 'BackCategoryController#deleteCategory', 'RoleMiddleware');
$router->addRoute('POST', '/admin/categories/update', 'BackCategoryController#updateCategory', 'RoleMiddleware');

// Utilisateurs
$router->addRoute('POST', '/admin/users/add', 'UserController#addUser', 'RoleMiddleware');
$router->addRoute('POST', '/admin/users/update', 'BackUserEditProfileController#updateUserGeneralInfo', 'RoleMiddleware');
$router->addRoute('POST', '/admin/users/updateAddresse', 'BackUserEditProfileController#updateUserAdresse', 'RoleMiddleware');
$router->addRoute('POST', '/admin/users/create', 'BackUserController#createUser', 'RoleMiddleware');
$router->addRoute('POST', '/admin/users/delete', 'BackUserController#deleteUser', 'RoleMiddleware');

// Articles
$router->addRoute('POST', '/admin/articles/uploadimage', 'ArticleController#uploadImage', 'RoleMiddleware');
$router->addRoute('POST', '/admin/articles/create', 'ArticleController#create', 'RoleMiddleware');
$router->addRoute('POST', '/admin/articles/update/{id}', 'ArticleController#update', 'RoleMiddleware');
$router->addRoute('POST', '/admin/articles/delete', 'ArticleController#delete', 'RoleMiddleware');

// Panier
$router->addRoute('POST', '/panier/checkoutsession', 'CheckoutController#postCheckoutSession');
$router->addRoute('POST', '/panier/confirmation', 'BasketController#confirmation');
$router->addRoute('POST', '/panier/add', 'BasketController#addTocart');
$router->addRoute('POST', '/panier/addOne', 'BasketController#addOneTocart');
$router->addRoute('POST', '/panier/removeOne', 'BasketController#removeOneTocart');
$router->addRoute('POST', '/panier/checkConnect', 'BasketController#checkConnect');
$router->addRoute('POST', '/panier/confirmationBeforePayment', 'CheckoutController#postConfirmationBeforePayment');
