<?php

namespace Admin\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function topMenuAction($route)
    {
        $menus = $this->get('admin.menu_getter')->getMenus($route);

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }

    public function indexAction() {
        $menus = $this->get("admin.menu_getter")->getMenus("");

        if (count($menus) == 0) {
            $this->addFlash("danger", "Vous n'avez aucun menu actif via votre profil sur cette application, veuillez contacter OI");
            return $this->redirectToRoute("application_index");
        }

        return $this->redirectToRoute($menus[0]["route"]);
    }
}
