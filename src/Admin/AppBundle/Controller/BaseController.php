<?php

namespace Admin\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function topMenuAction($route) {
        $menus = array();

        $menu = array("route" => "admin_user_manager_homepage",
            "name" => "Utilisateurs",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "news_index",
            "name" => "Groupes",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "news_index",
            "name" => "Applications",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "news_index",
            "name" => "News",
            "active" => "");

        array_push($menus, $menu);

        foreach ($menus as $key => &$val) {
            if ($val['route'] == $route) {
                $val['active'] = "active";
            }
        }

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}
