<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        $profilePerso = $usersCatalog = $productCatalog = $wishlistCatalog = $ordersCatalog = $logout = "";
        $usersCatalog = "using";

        return $this->twig->render('user/index.html.twig', ['users' => $users, 'profilePerso' => $profilePerso, 'usersCatalog' => $usersCatalog, 'productsCatalog' => $productCatalog, 'wishlistCatalog' => $wishlistCatalog, 'ordersCatalog' => $ordersCatalog, 'logout' => $logout]);
    }

    public function show($id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        return $this->twig->render('User/show.html.twig', [
            'user' => $user,
        ]);
    }

    public function add()
    {
        $userAdd['name'] = $userAdd['mail'] = $userAdd['password']  = $userAdd['birthday'] = "";
        $errors['user_name'] = $errors['email'] = $errors['password'] = $errors['birthday'] = "";
        function checkdata($data)
        {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = htmlentities($data);
            return $data;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['user_name']) | empty(trim($_POST['user_name']))) {
                $errors['user_name'] = "Le nom est obligatoire";
            } else {
                $userAdd['name'] = checkdata($_POST['user_name']);
            }
            if (!isset($_POST['email']) | empty(trim($_POST['email']))) {
                $errors['email'] = "L'email est obligatoire";
            } else {
                $userEmailCheck = checkdata($_POST['email']);
                $userManager = new UserManager();
                $userToCheck = $userManager->getUserByEmail($userEmailCheck);
                if (empty($userToCheck)){
                    $userAdd['mail'] = checkdata($_POST['email']);
                } else {
                    $errors['email'] = "Cet email est déjà utilisé";
                    $userAdd['mail'] = checkdata($_POST['email']);
                }
            }
            if (!isset($_POST['WS_password']) | empty(trim($_POST['WS_password']))) {
                $errors['password'] = "Le mot de passe est obligatoire";
            } else {
                $userAdd['password'] = checkdata($_POST['WS_password']);
            }
            if (!isset($_POST['birthday']) | empty(trim($_POST['birthday']))) {
                $errors['birthday'] = "La date de naissance est obligatoire";
            } else {
                $userAdd['birthday'] = checkdata($_POST['birthday']);

                $birthday = checkdata($_POST['birthday']);
                $timestamp = strtotime($birthday);
                if (!$timestamp) {
                    $errors['birthday'] = "La date de naissance fournie est invalide";
                } else {
                    // Calculer l'âge de l'utilisateur
                    $age = (date('Y') - date('Y', $timestamp));
                    if ($age < 18) {
                        $errors['birthday'] = "Vous devez avoir au moins 18 ans pour accéder à ce contenu";
                    } else {
                        $userAdd['birthday'] = $birthday;
                    }
                }
                if (empty($errors['user_name']) && empty($errors['email']) && empty($errors['password']) && empty($errors['birthday'])) {
                    $userManager = new UserManager();
                    $lastUser = $userManager->addUser($_POST);
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") {
                        header('Location:/users');
                    }
                    else {
                        $userManager = new UserManager();
                        $lastUser = $userManager->selectOneById($lastUser);

                        $user = $userManager->getUserByEmail($lastUser['email']);
                        $_SESSION['user'] = $user;
                        $_SESSION['user_id'] = $_SESSION['user']['id'];
                        header('Location:/contactPromo');
                    }
                }
            }
        }
        return $this->twig->render('User/add.html.twig', ['errors' => $errors, 'userAdd' => $userAdd]);
    }

    public function edit(int $id)
    {
        $userManager = new UserManager();
        $user['role'] = '';
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);
            $userManager->editUser($user);
            header('location: /profile');
        }
        $profilePerso = $userCatalog = $productCatalog = $wishlistCatalog = $ordersCatalog = $logout = "";
        $profilePerso = "using";

        return $this->twig->render('User/edit.html.twig', ['userChange' => $user, 'profilePerso' => $profilePerso, 'usersCatalog' => $userCatalog, 'productsCatalog' => $productCatalog, 'wishlistCatalog' => $wishlistCatalog, 'ordersCatalog' => $ordersCatalog, 'logout' => $logout]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $userManager = new UserManager();
            $userManager->delete($id);
            header('Location: /users');
        }
    }
}
