<?php

namespace Admin\UserManagerBundle\Controller;

use Admin\UserManagerBundle\Form\UserAdminEditType;
use Admin\UserManagerBundle\Form\UserType;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Entity\UserAgency;
use Front\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function updateBaseAction(Request $request, $idUser)
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

    public function updateAgenciesAction(Request $request, $idUser) {

    }


    public function updateAgencyAjaxAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->get('fos_user.user_manager');



            $idUser = $request->get('idUser');
            $idAgency = $request->get('idAgency');
            /** @var User $user */
            $user = $userManager->findUserBy(array("id" => $idUser));
            /** @var Agency $agency */
            $agency = $em->getRepository('FrontAppBundle:Agency')->find($idAgency);

            switch($request->get('type')) {
                case "add":
                    if (!in_array($agency, $user->getAgencies())) {
                        $user_agency = new UserAgency();
                        $user_agency->setUser($user);
                        $user_agency->setAgency($agency);
                        $user_agency->setPrincipal(false);

                        $em->persist($user_agency);
                        $em->flush();

                        if (count($user_agency->getUser()->getAgencies())== 0) {
                            $principale = 1;
                        }
                        else {
                            $principale = "";
                        }

                        return new JsonResponse('[{ "id" : "'.$user_agency->getId().'",
                                                                        "code": "'.$agency->getCode().'",
                                                                        "name": "'.$agency->getName().'",
                                                                        "function": "",
                                                                        "principale": "'.$principale.'"}]', 201);
                    }
                    else {
                        return new JsonResponse("L'utilisateur ".$user->getUsername() .
                            " appartient déjà à l'agence ".$agency->getCode()." ".$agency->getName().".", 515);
                    }
                    break;
                case "remove":
                    break;
                case "update":
                    break;
                default:

            }


        }
        return new Response("Nonnn ....");
    }
}
