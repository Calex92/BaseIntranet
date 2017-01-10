<?php

namespace Admin\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function topMenuAction($route) {
        $menus = array();
        $menu = array("route" => "admin_user_manager_homepage",
            "name" => "Utilisateurs",
            "active" => in_array($route,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create'))? "active": "");

        array_push($menus, $menu);

        $menu = array("route" => "admin_agency_manager_homepage",
            "name" => "Agences",
            "active" => in_array($route,
                array('admin_agency_manager_homepage', 'admin_agency_manager_add', 'admin_agency_manager_update')) ? "active" : "");

        array_push($menus, $menu);

        $menu = array("route" => "domain_manager_news_list_view",
            "name" => "Groupes",
            "active" => "");

        array_push($menus, $menu);

        $menu = array("route" => "domain_manager_news_list_view",
            "name" => "Applications",
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
