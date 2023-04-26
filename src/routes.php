<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'product' => ['ProductController', 'index',],
    'product/sort' => ['ProductController', 'sortPrice',['price']],
    'basket' => ['BasketController', 'index'],
    'product/sortSub' => ['ProductController', 'sortSubCategory',['subCat']],
    'users' => ['UserController', 'index'],
    'users/show' => ['UserController', 'show', ['id']],
    'users/add' => ['UserController', 'add'],
    'users/edit' => ['UserController', 'edit',['id']],
    'users/delete' => ['UserController', 'delete',['id']],
    'login' => ['LoginController', 'login'],
    'profile' => ['ProfileController', 'view'],
    'logout' => ['loginController', 'logout']
];
