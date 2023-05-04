<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return array(
    '' => array('HomeController', 'index',),
    'items' => array('ItemController', 'index',),
    'items/edit' => array('ItemController', 'edit', array('id')),
    'items/show' => array('ItemController', 'show', array('id')),
    'items/add' => array('ItemController', 'add',),
    'items/delete' => array('ItemController', 'delete',),
    'product' => array('productController', 'index'),
    'product/show' => array('ProductController', 'show', array('id')),
    'product/add' => array('ProductController', 'add', array('id')),
    'product/sort' => array('ProductController', 'sortPrice', array('price')),
    'product/sortSub' => array('ProductController', 'sortSubCategory', array('subCat')),
    'product/sortCat' => array('ProductController', 'sortCategory', array('cat')),

    'product/addProduct' => array('ProductController', 'addProd'),
    'product/showAll' => array('ProductController' , 'showAll'),
    'product/delete' => array('ProductController', 'delete', array('id')),
    'product/edit' => array('ProductController', 'edit', array('id')),

    'basket' => array('BasketController', 'index'),
    'basket/validation' => array('BasketController', 'validation'),
    'basket/edit' => array('BasketController', 'edit', array('id','quantity')),
    'basket/delete' => array('BasketController', 'delete', array('id')),
    'users' => array('UserController', 'index'),
    'users/show' => array('UserController', 'show', array('id')),
    'users/add' => array('UserController', 'add'),
    'users/edit' => array('UserController', 'edit', array('id')),
    'users/delete' => array('UserController', 'delete', array('id')),
    'login' => array('LoginController', 'login'),
    'profile' => array('ProfileController', 'view'),
    'profile/orders' => array('ProfileController', 'orders'),
    'logout' => array('loginController', 'logout'),
    'contact' => array('HomeController', 'contact'),
    'contact/envoi' => array('HomeController', 'contact'),

    /*'product/product/product/show' => ['ProductController', 'show', ['id']],*/
    /*'product/product/add' => ['ProductController', 'add',['id']],*/
    /*'product/product/product/add' => ['ProductController', 'add',['id']],*/
    /*'product/product/sortCat' => ['ProductController', 'sortCategory',['cat']],*/

);
