<?php

//////////////// fonction de création du panier ////////////////
function createCart()
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['cart']['productName'] = array();
        $_SESSION['cart']['productQuantity'] = array();
        $_SESSION['cart']['productPrice'] = array();
        $_SESSION['cart']['locker'] = false;
    }
    return true;
}

//////////////// fonction de verrou  ////////////////
function isLocked(){
    if (isset($_SESSION['cart']) && $_SESSION['cart']['locker'])
        return true;
    else
        return false;
}

//////////////// fonction d'ajout d'un article au panier ////////////////

function addItem($productName, $productQuantity, $productPrice)
{
    //Si le panier existe
    if (createCart() && !isLocked()) {
        //Si le produit existe déjà on ajoute seulement la quantité
        $productPosition = array_search($productName, $_SESSION['cart']['productName']);

        if ($productPosition !== false) {
            $_SESSION['cart']['productQuantity'][$productPosition] += $productQuantity;
        } else {
            //Sinon on ajoute le produit
            array_push($_SESSION['cart']['productName'], $productName);
            array_push($_SESSION['cart']['productQuantity'], $productQuantity);
            array_push($_SESSION['cart']['productPrice'], $productPrice);
        }
    } else {
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
    }
}

//////////////// fonction de suppression d'un article au panier ////////////////
function deleteItem($productName)
{
    //Si le panier existe
    if (createCart() && !isLocked()) {
        //Nous allons passer par un panier temporaire
        $tmp = array();
        $tmp['productName'] = array();
        $tmp['productQuantity'] = array();
        $tmp['productPrice'] = array();
        $tmp['locker'] = $_SESSION['cart']['verrou'];

        for ($i = 0; $i < count($_SESSION['cart']['productName']); $i++) {
            if ($_SESSION['panier']['productName'][$i] !== $productName) {
                array_push($tmp['productName'], $_SESSION['cart']['productName'][$i]);
                array_push($tmp['productQuantity'], $_SESSION['cart']['productQuantity'][$i]);
                array_push($tmp['productPrice'], $_SESSION['cart']['productPrice'][$i]);
            }
        }
        //On remplace le panier en session par notre panier temporaire à jour
        $_SESSION['cart'] =  $tmp;
        //On efface notre panier temporaire
        unset($tmp);
    } else {
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
    }
}

//////////////// fonction de modification d'un panier ////////////////
function modifyItemQuantity($productName,$qteProduit)
{
    //Si le panier existe
    if (createCart() && !isLocked()) {
        //Si la quantité est positive on modifie sinon on supprime l'article
        if ($productQuantity > 0) {
            //Recherche du produit dans le panier
            $productPosition = array_search($productName, $_SESSION['cart']['productName']);

            if ($productPosition !== false) {
                $_SESSION['cart']['productQuantity'][$productPosition] = $productQuantity;
            } else {
                deleteItem($productName);
            }
        else {
                echo "Un problème est survenu veuillez contacter l'administrateur du site.";
            }
        }
    }
}

//////////////// fonction de modification d'un panier ////////////////
function totalAmount(){
    $total=0;
    for($i = 0; $i < count($_SESSION['cart']['productName']); $i++)
    {
        $total += $_SESSION['cart']['productQuantity'][$i] * $_SESSION['cart']['productPrice'][$i];
    }
    return $total;
}


