<?php

namespace Admin\UserManagerBundle\Controller;

use Admin\AppBundle\Enum\RightsEnum;
use Admin\UserManagerBundle\Form\UserAdminEditType;
use Admin\UserManagerBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Front\AppBundle\Entity\Contact;
use Front\AppBundle\Entity\Group;
use Front\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get("fos_user.user_manager");
        $users = $userManager->findUsers();

        return $this->render('AdminUserManagerBundle:User:index.html.twig', array(
            "users" => $users,
            "canUpdate"     => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), $this->getParameter("application.id.administration"), RightsEnum::UPDATE_USER),
            "canConnectAs"  => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), $this->getParameter("application.id.administration"), RightsEnum::CONNECT_AS_USER)
        ));
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
        $agenciesForUser = $this->getDoctrine()->getRepository("FrontAppBundle:Agency")->getAgenciesNotUser($user->getId());

        //The validation is checked in the entity User.
        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $userManager->updateUser($user);

            $this->addFlash("success", "L'utilisateur " . $user->getSurname() . " " . $user->getFirstname() . " a bien été modifié");

            return $this->redirectToRoute("admin_user_manager_homepage");
        }

        return $this->render("AdminUserManagerBundle:User:update.html.twig", array(
            "form" => $form->createView(),
            "user" => $user,
            "agencies" => $agenciesForUser));
    }


    public function updateAgencyAjaxAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $userAgencyRepository = $this->getDoctrine()->getManager()->getRepository('FrontAppBundle:UserAgency');
            //This is the id of the user we want to update. It's send in the request.
            $idUser = $request->get('idUser');
            try {
                switch ($request->get('type')) {
                    case "add":
                        $idAgency = $request->get('idAgency');
                        $userAgencyRepository->addUserAgency($idUser, $idAgency);
                        break;
                    case "remove":
                        $idUserAgency = $request->get('idUserAgency');
                        $userAgencyRepository->removeUserAgency($idUserAgency);
                        break;
                    case "setPrincipal":
                        $idUserAgency = $request->get('idUserAgency');
                        $userAgencyRepository->setAsPrincipal($idUserAgency);
                        break;
                    default:
                        return new JsonResponse("Cette requête a généré un résultat inatendu. 
                    Veuillez réessayer. Si le problème persiste, contactez le HELP.", 515);
                }
            }//If an error has been throw during the previous operation, an exception is thrown
            catch (Exception $e) {
                return new JsonResponse($e->getMessage(), 515);
            }
            $jsonGenerator = $this->get("admin_user_manager_json_generator.agencies_for_ajax");
            return new JsonResponse($jsonGenerator->generateJsonForAjaxAgencies($idUser));
        }

        return new Response("Impossible de renvoyer un résultat");
    }

    public function loadAction(Request $request) {
        if ($request->isMethod("POST")) {
            $em = $this->getDoctrine()->getManager();
            foreach (simplexml_load_string($request->request->get("csvData")) as $line) {

                if ($line->prenom != "" &&
                    $line->email != "" &&
                    $line->nom != "" &&
                    $line->password != "" &&
                    $line->login != "") {

                    $user = new User();
                    $contact = new Contact();

                    $user->setUsername($line->login);
                    $user->setFirstname($line->prenom);
                    $user->setSurname($line->nom);
                    $user->setPlainPassword($line->password);
                    $user->setEmail($line->email);
                    $user->setEnabled($line->actif);
                    $user->setUpdatedAt(new \DateTime());
                    $user->setProfiles(new ArrayCollection());
                    $user->setGroup(new Group());

                    $user->setContact($contact);

                    $user->setRoles(array('Role_User'));

                    $em->persist($user);
                }
            }
            $em->flush();

        }

        return $this->render("@AdminUserManager/User/load.html.twig");
    }
}
