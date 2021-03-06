<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/01/2017
 * Time: 14:38
 */

namespace HelpReferentiel\AppBundle\Services;


use Front\DomainBundle\Services\MenuGetterBase;

class MenuGetter extends MenuGetterBase
{
    public function getMenus($currentRoute)
    {
        $menus = array();

        //Then, for each menu item, we see if the right is Ok with it
        $menu = array("route" => $this->router->generate("help_referentiel_app_request_index"),
            "name" => "Mes demandes",
            "active" => in_array($currentRoute,
                array('help_referentiel_app_request_index')) ? "active" : "");

        array_push($menus, $menu);

        $menu = array("name" => "Créer une demande",
            "active" => in_array($currentRoute,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "",
            "children" =>
                array(
                    array("route" => $this->router->generate("help_referentiel_app_request_index"),
                        "name" => "Saisir une demande de maintenance"),
                    array("route" => $this->router->generate("help_referentiel_app_request_index"),
                        "name" => "Saisir une demande de création multiple"),
                    array("route" => $this->router->generate("help_referentiel_app_request_index"),
                        "name" => "Saisir une demande de création unitaire")));

        array_push($menus, $menu);

        $menu = array("name" => "Export",
            "active" => in_array($currentRoute,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "",
            "children" =>
                array(
                    array("route" => $this->router->generate("help_referentiel_app_request_index"),
                        "name" => "Exporter les fiches de maintenance"),
                    array("route" => $this->router->generate("help_referentiel_app_request_index"),
                        "name" => "Exporter les fiches de création de produit")));

        array_push($menus, $menu);


        return $menus;
    }
}
