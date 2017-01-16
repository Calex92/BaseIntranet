<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Form\ProfileType;
use Front\AppBundle\Entity\Application;
use Front\AppBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    public function addAction(Request $request, Application $application) {
        $profile = new Profile();
        $profile->setApplication($application);

        $form = $this->get("form.factory")->create(ProfileType::class, $profile, array("application" => $application));

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);

            $em->flush();
            $this->addFlash("success", "Le profil a bien été ajouté");
            return $this->redirectToRoute("admin_application_manager_update", array("id" => $application->getId()));
        }

        return $this->render("@AdminApp/Profile/add.html.twig", array(
            "form" => $form->createView(),
            "profile"   => $profile
        ));
    }

    public function updateAction(Request $request, Profile $profile) {
        $form = $this->get("form.factory")->create(ProfileType::class, $profile, array("application" => $profile->getApplication()));

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Le profil a bien été modifié");
            return $this->redirectToRoute("admin_application_manager_update", array("id" => $profile->getApplication()->getId()));
        }
        return $this->render("AdminAppBundle:Profile:update.html.twig", array(
            "form" => $form->createView(),
            "profile"   => $profile
        ));
    }

    public function removeAction(Profile $profile) {
        if (count($profile->getUsers()) > 0 || count($profile->getGroups()) > 0) {
            $this->addFlash("danger", "Impossible de supprimer un profil appartenant à un utilisateurs ou à un groupe");
        }
        else {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($profile);
            $em->flush();
        }
        return $this->redirectToRoute("admin_application_manager_update", array("id" => $profile->getApplication()->getId()));
    }
}