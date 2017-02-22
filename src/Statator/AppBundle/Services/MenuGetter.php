<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 11:27
 */

namespace Statator\AppBundle\Services;


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
        $menu = array("route" => "statator_app_graph_index",
            "name" => "Généralités",
            "active" => in_array($currentRoute,
                array('statator_app_graph_index')) ? "active" : "");

        array_push($menus, $menu);

        $menu = array("name" => "Applications",
            "active" => in_array($currentRoute,
                array('statator_app_homepage', 'statator_app_homepage', 'statator_app_homepage')) ? "active" : "",
            "children" =>
                array(
                    array("route" => "statator_app_homepage",
                        "name" => "Administation"),
                    array("route" => "statator_app_homepage",
                        "name" => "News"),
                    array("route" => "statator_app_homepage",
                        "name" => "Helpdesk référentiel")));

        array_push($menus, $menu);


        return $menus;
    }
}