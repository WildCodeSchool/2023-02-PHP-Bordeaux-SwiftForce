<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

return [
    '' => ['HomeController', 'index',],
    'search' => ['SearchController', 'search',['q']],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'product' => ['productController', 'index'],
    'product/show' => ['ProductController', 'show', ['id']],
    'product/add' => ['ProductController', 'add',['id']],
    'product/sort' => ['ProductController', 'sortPrice',['price']],
    'product/sortSub' => ['ProductController', 'sortSubCategory',['subCat']],
    'product/sortCat' => ['ProductController', 'sortCategory',['cat']],
    'product/addProduct' => ['ProductController', 'addProd'],
    'product/showAll' => ['ProductController' , 'showAll'],
    'product/delete' => ['ProductController', 'delete', ['id']],
    'product/edit' => ['ProductController', 'edit', ['id']],
    'basket' => ['BasketController', 'index'],
    'basket/validation' => ['BasketController', 'validation'],
    'basket/edit' => ['BasketController', 'edit', ['id','quantity']],
    'basket/delete' => ['BasketController', 'delete', ['id']],
    'users' => ['UserController', 'index'],
    'users/show' => ['UserController', 'show', ['id']],
    'users/add' => ['UserController', 'add'],
    'users/edit' => ['UserController', 'edit',['id']],
    'users/delete' => ['UserController', 'delete',['id']],
    'login' => ['LoginController', 'login'],
    'profile' => ['ProfileController', 'view'],
    'profile/orders' => ['OrderController', 'index'],
    'profile/orders/show' => ['OrderController', 'show',['id']],
    'logout' => ['loginController', 'logout'],
    'contact' => ['HomeController', 'contact'],
    'contact/envoi' => ['HomeController', 'contact'],
    'wishlist' => ['WishlistController', 'index'],
    'wishlist/add' => ['WishlistController', 'add', ['id']],
    'wishlist/delete' => ['WishlistController', 'deleteWishlist', ['id']],
    'faker' => ['ProductController', 'productFixtures'],
    'promotion' => ['BasketController', 'promotion', ['codeName']],
    'contactPromo' => ['ProfileController', 'contactPromo'],
];
