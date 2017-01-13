<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 15:52
 */

namespace Admin\AppBundle\Services;


use Admin\AppBundle\Enum\RightsEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Front\AppBundle\Entity\Right;
use Front\UserBundle\Entity\User;

class MenuGetter
{
    private $application_id;

    /**
     * MenuGetter constructor.
     * @param $application_id
     */
    public function __construct($application_id)
    {
        $this->application_id = $application_id;
    }


    public function getMenus(User $user, $currentRoute) {
        $menus = array();
        // First we get the rights name for the current Application
        $rightsName = new ArrayCollection();
        foreach ($user->getRights($this->application_id) as $right) {
            /** @var Right $right */
            $rightsName->add($right->getName());
        }

        //Then, for each menu item, we see if the right is Ok with it
        if ($rightsName->contains(RightsEnum::SEE_USER) || $rightsName->contains(RightsEnum::UPDATE_USER)) {
            $menu = array("route" => "admin_user_manager_homepage",
                "name" => "Utilisateurs",
                "active" => in_array($currentRoute,
                    array('admin_user_manager_update', 'admin_user_manager_homepage', 'admin_user_manager_create')) ? "active" : "");

            array_push($menus, $menu);
        }

        //"SeeGroup", "UpdateGroup"
        if ($rightsName->contains(RightsEnum::SEE_GROUP) || $rightsName->contains(RightsEnum::UPDATE_GROUP)) {
            $menu = array("route" => "admin_group_manager_homepage",
                "name" => "Groupes",
                "active" => in_array($currentRoute,
                    array('admin_group_manager_homepage', 'admin_group_manager_add', 'admin_group_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        //"SeeApp", "UpdateApp"
        if ($rightsName->contains(RightsEnum::SEE_APPLICATION) || $rightsName->contains(RightsEnum::UPDATE_APPLICATION)) {
            $menu = array("route" => "admin_application_manager_homepage",
                "name" => "Applications",
                "active" => in_array($currentRoute,
                    array('admin_application_manager_homepage', 'admin_application_manager_add', 'admin_application_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($rightsName->contains(RightsEnum::SEE_AGENCY) || $rightsName->contains(RightsEnum::UPDATE_AGENCY)) {
            $menu = array("route" => "admin_agency_manager_homepage",
                "name" => "Agences",
                "active" => in_array($currentRoute,
                    array('admin_agency_manager_homepage', 'admin_agency_manager_add', 'admin_agency_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($rightsName->contains(RightsEnum::SEE_REGION) || $rightsName->contains(RightsEnum::UPDATE_REGION)) {
            $menu = array("route" => "admin_region_manager_homepage",
                "name" => "Régions",
                "active" => in_array($currentRoute,
                    array('admin_region_manager_homepage', 'admin_region_manager_add', 'admin_region_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        if ($rightsName->contains(RightsEnum::SEE_ZONE) || $rightsName->contains(RightsEnum::UPDATE_ZONE)) {
            $menu = array("route" => "admin_zone_manager_homepage",
                "name" => "Zones",
                "active" => in_array($currentRoute,
                    array('admin_zone_manager_homepage', 'admin_zone_manager_add', 'admin_zone_manager_update')) ? "active" : "");

            array_push($menus, $menu);
        }

        return $menus;
    }
}