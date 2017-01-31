<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 24/11/2016
 * Time: 10:01
 */

namespace Front\DomainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Security("has_role('ROLE_DOMAIN_BASE')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction() {
        $menus = $this->get("front_domain.menu_getter")->getMenus("");

        if (count($menus) == 0) {
            $this->addFlash("danger", "Vous n'avez aucun menu actif via votre profil sur cette application, veuillez contacter OI");
            return $this->redirectToRoute("application_index");
        }

        return $this->redirectToRoute($menus[0]["route"]);
    }

    public function documentAction() {

    }

    public function topMenuAction($route) {
        $menus = $this->get("front_domain.menu_getter")->getMenus($route);

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}
