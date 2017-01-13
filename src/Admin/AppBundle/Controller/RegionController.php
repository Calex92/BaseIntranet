<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Enum\RightsEnum;
use Admin\AppBundle\Form\RegionType;
use Front\AppBundle\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegionController extends Controller
{
    public function indexAction() {
        $regions = $this->get("doctrine")->getRepository("FrontAppBundle:Region")->findAll();

        return $this->render("AdminAppBundle:Region:index.html.twig", array(
            "regions" => $regions,
            "canUpdate" => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), $this->getParameter("application.id.administration"), RightsEnum::UPDATE_REGION)
        ));
    }

    public function addAction(Request $request) {
        $region = new Region();
        $form = $this->get("form.factory")->create(RegionType::class, $region);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($region);

            $em->flush();
            $this->addFlash("success", "La région a bien été ajoutée");
            return $this->redirectToRoute("admin_region_manager_homepage");
        }

        return $this->render("@AdminApp/Region/add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id) {
        $region = $this->get("doctrine")->getRepository("FrontAppBundle:Region")->find($id);
        $form = $this->get("form.factory")->create(RegionType::class, $region);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "La région a bien été modifiée");
            return $this->redirectToRoute("admin_region_manager_homepage");
        }
        return $this->render("AdminAppBundle:Region:update.html.twig", array(
            "form" => $form->createView()
        ));
    }
}