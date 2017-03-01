<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/02/2017
 * Time: 09:00
 */

namespace Front\AppBundle\Services;


use Front\DomainBundle\Services\MenuGetterBase;

class MenuGetter extends MenuGetterBase
{
    public function getMenus($currentRoute)
    {
        $menus = array();

        //Then, for each menu item, we see if the right is Ok with it
        $menu = array("route" => $this->router->generate("domain_manager_news_list_view"),
            "name" => "News",
            "active" => in_array($currentRoute,
                array('domain_manager_news_list_view', 'front_homepage', 'domain_manager_news_view')) ? "active" : "");

        array_push($menus, $menu);


        $menu = array("route" => $this->router->generate("domain_manager_documents_view"),
            "name" => "Documents références",
            "active" => in_array($currentRoute,
                array('domain_manager_documents_view')) ? "active" : "");

        array_push($menus, $menu);


        if ($this->authorization_checker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu = array("route" => $this->router->generate("application_index"),
                "name" => "Applications",
                "active" => in_array($currentRoute,
                    array('application_index')) ? "active" : "");

            array_push($menus, $menu);
        }

        $menu = array("route" => $this->router->generate("front_help"),
            "name" => "Aide",
            "active" => in_array($currentRoute,
                array('front_help')) ? "active" : "");

        array_push($menus, $menu);

        return $menus;
    }
}
