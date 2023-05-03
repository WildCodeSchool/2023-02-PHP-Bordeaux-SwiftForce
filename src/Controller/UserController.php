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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userManager->addUser($_POST);

            header('Location: /login');
        }
        return $this->twig->render('User/add.html.twig');
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
