<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function userAction()
    {
        return $this->render('@FrontApp/Admin/user.html.twig');
    }
    
    public function topMenuAction($route) {
        $menus = array();

        $menu = array("route" => "users_admin",
            "name" => "Utilisateurs",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "front_homepage",
            "name" => "Groupes",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "front_homepage",
            "name" => "Applications",
            "active" => "");

        array_push($menus, $menu);

        foreach ($menus as $key => &$val) {
            if ($val['route'] == $route) {
                $val['active'] = "active";
            }
        }

        return $this->render('@FrontApp/Admin/topMenu.html.twig', array("menus" => $menus));
    }
}
