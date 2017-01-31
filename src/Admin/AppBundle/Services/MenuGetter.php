<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 15:52
 */

namespace Admin\AppBundle\Services;


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


    public function getMenus($currentRoute) {
        $menus = array();

        //Then, for each menu item, we see if the right is Ok with it
        if ($this->authorization_checker->isGranted('ROLE_ADMIN_USER_VIEW')) {
            $menu = array("route" => "admin_user_manager_homepage",
                "name" => "Utilisateurs",
                "active" => in_array($currentRoute,
                    array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "");

            array_push($menus, $menu);
        }

        //"SeeGroup", "UpdateGroup"
        if ($this->authorization_checker->isGranted('ROLE_ADMIN_GROUP_VIEW')) {
            $menu = array("route" => "admin_group_manager_homepage",
                "name" => "Groupes",
                "active" => in_array($currentRoute,
                    array('admin_group_manager_homepage', 'admin_group_manager_add', 'admin_group_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        //"SeeApp", "UpdateApp"
        if ($this->authorization_checker->isGranted('ROLE_ADMIN_APPLICATION_VIEW')) {
            $menu = array("route" => "admin_application_manager_homepage",
                "name" => "Applications",
                "active" => in_array($currentRoute,
                    array('admin_application_manager_homepage', 'admin_application_manager_add', 'admin_application_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($this->authorization_checker->isGranted('ROLE_ADMIN_AGENCY_VIEW')) {
            $menu = array("route" => "admin_agency_manager_homepage",
                "name" => "Agences",
                "active" => in_array($currentRoute,
                    array('admin_agency_manager_homepage', 'admin_agency_manager_add', 'admin_agency_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($this->authorization_checker->isGranted('ROLE_ADMIN_REGION_VIEW')) {
            $menu = array("route" => "admin_region_manager_homepage",
                "name" => "Régions",
                "active" => in_array($currentRoute,
                    array('admin_region_manager_homepage', 'admin_region_manager_add', 'admin_region_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($this->authorization_checker->isGranted('ROLE_ADMIN_ZONE_VIEW')) {
            $menu = array("route" => "admin_zone_manager_homepage",
                "name" => "Zones",
                "active" => in_array($currentRoute,
                    array('admin_zone_manager_homepage', 'admin_zone_manager_add', 'admin_zone_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        return $menus;
    }
}
