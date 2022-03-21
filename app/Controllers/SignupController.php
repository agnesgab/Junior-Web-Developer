<?php

namespace App\Controllers;

use App\Database;
use App\Models\User;
use App\Redirect;
use App\View;

const NAME_REQUIRED = "Please enter your name";
const EMAIL_REQUIRED = 'Please enter your email';
const EMAIL_INVALID = 'Please enter a valid email';
const EMAIL_TAKEN = "Email already taken";

class SignupController
{

    public function signup()
    {

        return new View('User/signup.html');

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function filterInput()
    {

        $errors = [];

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $emailRowsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('email')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)
            ->executeQuery()
            ->rowCount();

        if ($emailRowsQuery > 0) {

            $errors[] = EMAIL_TAKEN;

        }

        if ($name) {
            $name = trim($name);
            if ($name === '') {
                $errors[] = NAME_REQUIRED;
            }
        } else {
            $errors[] = NAME_REQUIRED;
        }


        if ($email) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                $errors[] = EMAIL_INVALID;
            }
        } else {
            $errors[] = EMAIL_REQUIRED;
        }

        if (!empty($errors)) {
            return new View('User/signup.html', ['errors' => $errors]);
        }


        Database::connection()
            ->insert('users', ['name' => $name, 'email' => $email]);

        $userIdQuery = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)
            ->executeQuery()
            ->fetchOne();

        $userId = (int)$userIdQuery;

        return new Redirect('/success/' . $userId . '/' . $name);


    }


}