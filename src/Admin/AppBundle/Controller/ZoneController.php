<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Form\ZoneType;
use Front\AppBundle\Entity\Zone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ZoneController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN_ZONE_VIEW')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        $zones = $this->get("doctrine")->getRepository("FrontAppBundle:Zone")->findAll();

        return $this->render("AdminAppBundle:Zone:index.html.twig", array(
            "zones" => $zones
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN_ZONE_UPDATE')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request) {
        $zones = new Zone();
        $form = $this->get("form.factory")->create(ZoneType::class, $zones);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zones);

            $em->flush();
            $this->addFlash("success", "La zone a bien été ajoutée");
            return $this->redirectToRoute("admin_zone_manager_homepage");
        }

        return $this->render("@AdminApp/Zone/add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN_ZONE_UPDATE')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id) {
        $zones = $this->get("doctrine")->getRepository("FrontAppBundle:Zone")->find($id);
        $form = $this->get("form.factory")->create(ZoneType::class, $zones);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "La zone a bien été modifiée");
            return $this->redirectToRoute("admin_zone_manager_homepage");
        }
        return $this->render("AdminAppBundle:Zone:update.html.twig", array(
            "form" => $form->createView()
        ));
    }
}