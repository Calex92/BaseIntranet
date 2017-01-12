<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Enum\RightsEnum;
use Admin\AppBundle\Form\ApplicationType;
use Front\AppBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApplicationController extends Controller
{

    public function indexAction() {
        $applications = $this->get("doctrine")->getRepository("FrontAppBundle:Application")->findAll();

        return $this->render("AdminAppBundle:Application:index.html.twig", array(
            "applications" => $applications,
            "canUpdate" => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), BaseController::APPLICATION_NAME, RightsEnum::UPDATE_APPLICATION)
        ));
    }

    public function addAction(Request $request) {
        $application = new Application();
        $form = $this->get("form.factory")->create(ApplicationType::class, $application);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);

            $em->flush();
            $this->addFlash("success", "L'application a bien été ajoutée");
            return $this->redirectToRoute("admin_application_manager_homepage");
        }

        return $this->render("AdminAppBundle:Application:add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id) {
        $application = $this->get("doctrine")->getRepository("FrontAppBundle:Application")->find($id);
        $form = $this->get("form.factory")->create(ApplicationType::class, $application);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "L'application a bien été modifiée");
            return $this->redirectToRoute("admin_application_manager_homepage");
        }
        return $this->render("AdminAppBundle:Application:update.html.twig", array(
            "form"  => $form->createView(),
            "application" => $application
        ));
    }
}