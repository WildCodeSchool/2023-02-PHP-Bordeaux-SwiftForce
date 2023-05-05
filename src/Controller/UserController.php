<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        return $this->twig->render('user/index.html.twig', ['users' => $users]);
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
        $user['name'] = $user['mail'] = $user['password']  = $user['birthday'] = "";
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
                $user['name'] = checkdata($_POST['user_name']);
            }
            if (!isset($_POST['email']) | empty(trim($_POST['email']))) {
                $errors['email'] = "L'email est obligatoire";
            } else {
                $user['mail'] = checkdata($_POST['email']);
            }
            if (!isset($_POST['WS_password']) | empty(trim($_POST['WS_password']))) {
                $errors['password'] = "Le mot de passe est obligatoire";
            } else {
                $user['password'] = checkdata($_POST['WS_password']);
            }
            if (!isset($_POST['birthday']) | empty(trim($_POST['birthday']))) {
                $errors['birthday'] = "La date de naissance est obligatoire";
            } else {
                $user['birthday'] = checkdata($_POST['birthday']);
            }

            if(empty($errors['user_name']) && empty($errors['email']) && empty($errors['password']) && empty($errors['birthday'])) {
                $userManager = new UserManager();
                $userManager->addUser($_POST);
                header('Location: /login');
            }
        }
        return $this->twig->render('User/add.html.twig', ['errors' => $errors, 'user' => $user]);
    }

    public function edit(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);

            $userManager->editUser($user);
            header('location: /users/show?id=' . $id);
        }

        return $this->twig->render('User/edit.html.twig', [
            'user' => $user,
        ]);
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
