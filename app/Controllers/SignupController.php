<?php

namespace App\Controllers;

use App\Database;
use App\Redirect;
use App\Validation\UserValidator;
use App\View;

class SignupController
{
    public function signup()
    {
        return new View('User/signup.html');
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function storeUser()
    {
        if (isset($_POST['submit'])) {
            $validation = new UserValidator($_POST);
        }

        $errors = $validation->validateForm();

        if (!empty($errors)) {
            return new View('User/signup.html', ['errors' => $errors]);
        }

        Database::connection()
            ->insert('users', ['name' => $_POST['name'], 'email' => $_POST['email']]);

        $userIdQuery = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $_POST['email'])
            ->executeQuery()
            ->fetchOne();

        $userId = (int)$userIdQuery;

        return new Redirect('/success/' . $userId . '/' . $_POST['name']);
    }
}