<?php

namespace Admin\UserManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get("fos_user.user_manager");
        $users = $userManager->findUsers();

        return $this->render('AdminUserManagerBundle:User:index.html.twig',
            array("users" => $users));
    }
}
