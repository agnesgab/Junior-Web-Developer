<?php

namespace App\Controllers;

use App\Database;
use App\Models\User;
use App\Redirect;
use App\View;

class PageController
{


    public function showHome()
    {

        return new View('Page/home.html');

    }

    public function showServices()
    {


        return new View('Page/services.html');

    }

    public function showAbout()
    {

        return new View('Page/about.html');

    }

    public function showContact()
    {

        return new View('Page/contact.html');

    }

    public function showFaq()
    {

        return new View('Page/faq.html');

    }

    public function showLearnMore()
    {

        return new View('Page/more.html');

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function showSuccess(array $vars)
    {

        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $vars['userId'])
            ->executeQuery()
            ->fetchAllAssociative();

        if (!empty($userQuery)) {
            foreach ($userQuery as $data) {
                $user = new User($data['id'], $data['name'], $data['email']);
            }
        } else {
            return new Redirect('/');
        }


        return new View('User/success.html', ['user' => $user]);

    }

}