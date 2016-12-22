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
        return $this->redirectToRoute("domain_manager_news_index");
    }

    public function documentAction() {

    }

    public function topMenuAction($route) {
        $menus = array();
        $menus[] = array("route" => "domain_manager_news_index",
            "name" => "News",
            "active" => in_array($route,
                array('domain_manager_news_index', 'domain_manager_news_add', 'domain_manager_news_modify'))? "active": "");

        $menus[] = array("route" => "domain_manager_document_index",
            "name" => "Documents",
            "active" => in_array($route,
                array('domain_manager_document_index', 'domain_manager_document_add', 'domain_manager_document_modify'))? "active" : "");

        $menus[] = array("route" => "domain_manager_catalog_index",
            "name" => "Catalogues",
            "active" => in_array($route,
                array('domain_manager_catalog_index', 'domain_manager_catalog_add', 'domain_manager_catalog_modify'))? "active" : "");

        $menus[] = array("route" => "domain_manager_domain_index",
            "name" => "Domaines",
            "active" => in_array($route,
                array('domain_manager_domain_index'))? "active" : "");

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}