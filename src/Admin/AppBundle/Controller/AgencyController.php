<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Enum\RightsEnum;
use Admin\AppBundle\Form\AgencyType;
use Front\AppBundle\Entity\Agency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AgencyController extends Controller
{
    public function indexAction() {
        $agencies = $this->get("doctrine")->getRepository("FrontAppBundle:Agency")->findAll();

        return $this->render("AdminAppBundle:Agency:index.html.twig", array(
            "agencies"  => $agencies,
            "canUpdate" => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), $this->getParameter("application.id.administration"), RightsEnum::UPDATE_AGENCY)
        ));
    }

    public function addAction(Request $request) {
        $agency = new Agency();
        $form = $this->get("form.factory")->create(AgencyType::class, $agency);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agency);

            $em->flush();
            $this->addFlash("success", "L'agence a bien été ajoutée");
            return $this->redirectToRoute("admin_agency_manager_homepage");
        }

        return $this->render("@AdminApp/Agency/add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id) {
        $agency = $this->get("doctrine")->getRepository("FrontAppBundle:Agency")->find($id);
        $form = $this->get("form.factory")->create(AgencyType::class, $agency);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "L'agence a bien été modifiée");
            return $this->redirectToRoute("admin_agency_manager_homepage");
        }
        return $this->render("AdminAppBundle:Agency:update.html.twig", array(
            "form" => $form->createView()
        ));
    }
}