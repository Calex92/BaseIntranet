<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 15:52
 */

namespace Front\DomainBundle\Services;


class MenuGetter extends MenuGetterBase
{
    public function getMenus($currentRoute) {
        $menus = array();
        if ($this->authorization_checker->isGranted("ROLE_DOMAIN_NEWS_DOCUMENT")) {
            $menus[] = array("route" => $this->router->generate("domain_manager_news_index"),
                "name" => "News",
                "active" => in_array($currentRoute,
                    array('domain_manager_news_index', 'domain_manager_news_add', 'domain_manager_news_modify')) ? "active" : "");
        }
        if ($this->authorization_checker->isGranted("ROLE_DOMAIN_NEWS_DOCUMENT")) {
            $menus[] = array("route" => $this->router->generate("domain_manager_document_index"),
                "name" => "Documents",
                "active" => in_array($currentRoute,
                    array('domain_manager_document_index', 'domain_manager_document_add', 'domain_manager_document_modify')) ? "active" : "");
        }
        if ($this->authorization_checker->isGranted("ROLE_DOMAIN_CATALOG")) {
            $menus[] = array("route" => $this->router->generate("domain_manager_catalog_index"),
                "name" => "Catalogues",
                "active" => in_array($currentRoute,
                    array('domain_manager_catalog_index', 'domain_manager_catalog_add', 'domain_manager_catalog_modify')) ? "active" : "");
        }
        if ($this->authorization_checker->isGranted("ROLE_DOMAIN_ADMIN")) {
            $menus[] = array("route" => $this->router->generate("domain_manager_domain_index"),
                "name" => "Domaines",
                "active" => in_array($currentRoute,
                    array('domain_manager_domain_index', 'domain_manager_domain_add', 'domain_manager_domain_modify')) ? "active" : "");
        }

        return $menus;
    }
}
