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

        $menus[] = array("route" => "domain_manager_document",
            "name" => "Documents",
            "active" => in_array($route,
                array('domain_manager_document', 'domain_manager_add_document', 'domain_manager_modify_document'))? "active" : "");

        $menus[] = array("route" => "domain_manager_catalog_index",
            "name" => "Catalogues",
            "active" => in_array($route,
                array('domain_manager_catalog_index', 'domain_manager_add_catalog', 'domain_manager_modify_catalog'))? "active" : "");

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}