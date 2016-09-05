<?php

namespace Admin\UserManagerBundle\Controller;

use Admin\UserManagerBundle\Form\UserAdminEditType;
use Admin\UserManagerBundle\Form\UserType;
use Front\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get("fos_user.user_manager");
        $users = $userManager->findUsers();

        return $this->render('AdminUserManagerBundle:User:index.html.twig',
            array("users" => $users));
    }

    public function createAction(Request $request) {
        //We create a new user to fill the form with the user manager
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(UserType::class, $user);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid() && $form->isValid()) {
            $userManager->updateUser($user);
            $this->get("session")->getFlashBag()->add('success', "L'utilisateur a bien été créé");
            return $this->redirectToRoute("admin_user_manager_homepage");
        }

        return $this->render('AdminUserManagerBundle:User:create.html.twig',
            array('form' => $form->createView()));
    }

    public function updateAction(Request $request, $idUser)
    {
        $userManager = $this->get('fos_user.user_manager');
        /** @var User $user */
        $user = $userManager->findUserBy(array("id" => $idUser));


        //If the user is not in database, redirect to the home page
        if ($user === null) {
            $this->get("session")->getFlashBag()->add("info", "L'utilisateur d'identifiant '" . $idUser . "' est introuvable");
            return $this->redirectToRoute("admin_user_manager_homepage");
        }

        $form = $this->createForm(UserAdminEditType::class, $user);

        //The validation is checked in the entity User.
        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $userManager->updateUser($user);
            $this->get('session')->getFlashBag()
                ->add("success", "L'utilisateur " . $user->getSurname() . " " . $user->getFirstname() . " a bien été modifié");

            return $this->redirectToRoute("admin_user_manager_homepage");
        }

        return $this->render("AdminUserManagerBundle:User:update.html.twig", array(
            "form" => $form->createView(),
            "user" => $user));
    }
}
