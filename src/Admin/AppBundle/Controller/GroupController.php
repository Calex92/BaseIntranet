<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 09:59
 */

namespace Admin\AppBundle\Controller;


use Admin\AppBundle\Enum\RightsEnum;
use Admin\AppBundle\Form\GroupType;
use Front\AppBundle\Entity\Group;
use Front\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends Controller
{
    public function indexAction() {
        $groups = $this->get("doctrine")->getRepository("FrontAppBundle:Group")->findAll();

        return $this->render("AdminAppBundle:Group:index.html.twig", array(
            "groups" => $groups,
            "canUpdate" => $this->get("frontapp.right_checker")
                ->userCanSee($this->getUser(), $this->getParameter("application.code.administration"), RightsEnum::UPDATE_GROUP)
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

    public function updateAction(Request $request, Group $group) {
        $form = $this->get("form.factory")->create(GroupType::class, $group);

        if ($request->isMethod("POST") && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // We have to remove the prefered profile for each users from this group.
            // We should also create a notification to explain why the profiles are removed.
            foreach ($group->getUsers() as $user) {
                /** @var User $user */
                foreach ($user->getProfilesPrefered() as $preferedProfile) {
                    $em->remove($preferedProfile);
                }
            }

            $em->flush();
            $this->addFlash("success", "Le groupe a bien été modifié, les profils préférés des utilisateurs ont été réinitialisés.");
            return $this->redirectToRoute("admin_group_manager_homepage");
        }
        return $this->render("AdminAppBundle:Group:update.html.twig", array(
            "form"  => $form->createView(),
            "group" => $group
        ));
    }
}