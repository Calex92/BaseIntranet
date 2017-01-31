<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/01/2017
 * Time: 14:38
 */

namespace HelpReferentiel\AppBundle\Services;


use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuGetter
{
    /**
     * @var AuthorizationChecker
     */
    private $authorization_checker;


    /**
     * MenuGetter constructor.
     * @param $authorization_checker
     * @internal param $application_code
     */
    public function __construct(AuthorizationChecker $authorization_checker)
    {
        $this->authorization_checker = $authorization_checker;
    }


    public function getMenus($currentRoute)
    {
        $menus = array();

        //Then, for each menu item, we see if the right is Ok with it
        $menu = array("route" => "help_referentiel_app_request_index",
            "name" => "Mes demandes",
            "active" => in_array($currentRoute,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "");

        array_push($menus, $menu);

        $menu = array("route" => "help_referentiel_app_request_index",
            "name" => "Créer une demande",
            "active" => in_array($currentRoute,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "",
            "children" =>
                array(
                    array("route" => "help_referentiel_app_request_index",
                        "name" => "Saisir une demande de maintenance"),
                    array("route" => "help_referentiel_app_request_index",
                        "name" => "Saisir une demande de création multiple"),
                    array("route" => "help_referentiel_app_request_index",
                        "name" => "Saisir une demande de création unitaire")));

        array_push($menus, $menu);

        $menu = array("route" => "help_referentiel_app_request_index",
            "name" => "Export",
            "active" => in_array($currentRoute,
                array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "",
            "children" =>
                array(
                    array("route" => "help_referentiel_app_request_index",
                        "name" => "Exporter les fiches de maintenance"),
                    array("route" => "help_referentiel_app_request_index",
                        "name" => "Exporter les fiches de création de produit")));

        array_push($menus, $menu);


        return $menus;
    }
}