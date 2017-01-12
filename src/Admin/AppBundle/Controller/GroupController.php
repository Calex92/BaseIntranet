<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Form\GroupType;
use Front\AppBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends Controller
{
    public function indexAction() {
        $groups = $this->get("doctrine")->getRepository("FrontAppBundle:Group")->findAll();

        return $this->render("AdminAppBundle:Group:index.html.twig", array(
            "groups" => $groups
        ));
    }

    public function addAction(Request $request) {
        $group = new Group();
        $form = $this->get("form.factory")->create(GroupType::class, $group);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);

            $em->flush();
            $this->addFlash("success", "Le groupe a bien été ajouté");
            return $this->redirectToRoute("admin_group_manager_homepage");
        }

        return $this->render("@AdminApp/Group/add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id) {
        $group = $this->get("doctrine")->getRepository("FrontAppBundle:Group")->find($id);
        $form = $this->get("form.factory")->create(GroupType::class, $group);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Le groupe a bien été modifié");
            return $this->redirectToRoute("admin_group_manager_homepage");
        }
        return $this->render("AdminAppBundle:Group:update.html.twig", array(
            "form"  => $form->createView(),
            "group" => $group
        ));
    }
}