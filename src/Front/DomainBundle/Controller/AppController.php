<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 24/11/2016
 * Time: 10:01
 */

namespace Front\DomainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction() {
        return $this->redirectToRoute("domain_manager_news");
    }





    public function documentAction() {

    }

    public function topMenuAction($route) {
        $menus = array();
        $menus[] = array("route" => "domain_manager_news",
            "name" => "News",
            "active" => in_array($route,
                array('domain_manager_news', 'domain_manager_add_news', 'domain_manager_modify_news'))? "active": "");

        $menus[] = array("route" => "news_index",
            "name" => "Documents",
            "active" => "");

        foreach ($menus as $key => &$val) {
            if ($val['route'] == $route) {
                $val['active'] = "active";
            }
        }

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}