<?php

namespace Admin\UserManagerBundle\Controller;

use Admin\UserManagerBundle\Form\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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

            try {
                $userManager->updateUser($user);
                $this->get("session")->getFlashBag()->add('success', "L'utilisateur a bien été créé");
                return $this->redirectToRoute("admin_user_manager_homepage");
            } catch (UniqueConstraintViolationException $e) {
                //This catch the exceptions in case you want to add a user that's already his username or email adress in
                //the database.
                if (strstr($e->getMessage(), "8D93D64992FC23A8")) {
                    $errorMessage = "Le nom d'utilisateur est déjà utilisé";
                } else if (strstr($e->getMessage(), "8D93D649A0D96FBF")) {
                    $errorMessage = "L'adresse mail est déjà utilisée";
                }
                else {
                    $errorMessage = "Une erreur s'est produite durant la création de l'utilisateur, veuillez 
                    faire une capture d'écran de cette erreur : ".$e->getMessage();
                }

                $this->get("session")->getFlashBag()->add('danger', $errorMessage);
            }
        }

        return $this->render('AdminUserManagerBundle:User:create.html.twig',
            array('form' => $form->createView()));
    }
}
