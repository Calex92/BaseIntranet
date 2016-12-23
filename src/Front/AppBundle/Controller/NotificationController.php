<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/12/2016
 * Time: 17:07
 */

namespace Front\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function indexAction($page) {
        $nbPerPage  = 20;
        $notifications = $this->getDoctrine()->getRepository("FrontAppBundle:Notification")->getPaginator($this->getUser()->getId(), $page, $nbPerPage);

        $nbPages = ceil(count($notifications) / $nbPerPage);
        // If the page doesn't exist, throw an Exception
        if ($page > $nbPages) {
            $this->get("session")->getFlashBag()->add("danger", "La page sélectionnée n'existe pas");
            return $this->redirectToRoute("user_notifications");
        }

        return $this->render("@FrontApp/Notification/index.html.twig", array(
            "notifications" => $notifications,
            "page"          => $page,
            "nbPages"       => $nbPages
        ));
    }

    public function viewAction($id) {
        $notification = $this->getDoctrine()->getRepository("FrontAppBundle:Notification")->find($id);
        if ($notification == NULL || $notification->getUser()->getId() != $this->getUser()->getId()) {
            $this->get("session")->getFlashBag()->add("danger", "Cette notification ne vous concerne pas.");
            return $this->redirectToRoute("user_notifications");
        }
        $notification->setSeen(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute($notification->getRoute(), $notification->getParams());
    }
}