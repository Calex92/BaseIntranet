<?php

namespace Admin\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    const APPLICATION_NAME = "Administration Isidore 2";
    public function topMenuAction($route)
    {
        $menus = $this->get('admin.menu_getter')->getMenus($this->getUser(), $route);

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }

    public function indexAction() {
        $menus = $this->get("admin.menu_getter")->getMenus($this->getUser(), "");

        if (count($menus) == 0) {
            $this->addFlash("danger", "Vous n'avez aucun menu actif via votre profil sur cette application, veuillez contacter OI");
            return $this->redirectToRoute("application_index");
        }

        return $this->redirectToRoute($menus[0]["route"]);
    }
}
