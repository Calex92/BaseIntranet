<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 11:27
 */

namespace Statator\AppBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use Front\AppBundle\Entity\Application;
use Front\DomainBundle\Services\MenuGetterBase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuGetter extends MenuGetterBase
{
    private $entityManager;

    /**
     * MenuGetter constructor.
     * @param AuthorizationCheckerInterface $authorization_checker
     * @param RouterInterface $router
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(AuthorizationCheckerInterface $authorization_checker, RouterInterface $router, EntityManagerInterface $entityManager)
    {
        parent::__construct($authorization_checker, $router);
        $this->entityManager = $entityManager;
    }

    public function getMenus($currentRoute)
    {
        $menus = array();

        //Then, for each menu item, we see if the right is Ok with it
        $menu = array("route" => $this->router->generate("statator_app_graph_index"),
            "name" => "Généralités",
            "active" => in_array($currentRoute,
                array('statator_app_graph_index')) ? "active" : "");

        array_push($menus, $menu);

        $menu = $this->getMenuForApplications($currentRoute);

        array_push($menus, $menu);

        return $menus;
    }

    private function getMenuForApplications ($currentRoute) {
        /* We get the applications that are only internal */
        $internalApplications = $this->entityManager
            ->getRepository("FrontAppBundle:Application")
            ->findInternalApplication();

        $routes = array();
        $children = array();

        foreach ($internalApplications as $internalApplication) {
            /** @var Application $internalApplication */
            $route = $this->router->generate("statator_app_application", array("code" => $internalApplication->getCode()));
            $routes[] = "statator_app_application";

            $children[] = array("route" => $route, "name" => $internalApplication->getName());
        }

        return array("name" => "Applications",
            "active" => in_array($currentRoute,
                $routes) ? "active" : "",
            "children" => $children
        );
    }
}
