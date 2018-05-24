<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 24/11/2016
 * Time: 10:01
 */

namespace Front\DomainBundle\Controller;

use Front\DomainBundle\Services\MenuGetter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Security("has_role('ROLE_DOMAIN_BASE')")
     * @param MenuGetter $menuGetter
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(MenuGetter $menuGetter) {
        $menus = $menuGetter->getMenus("");

        if (count($menus) == 0) {
            $this->addFlash("danger", "Vous n'avez aucun menu actif via votre profil sur cette application, veuillez contacter OI");
            return $this->redirectToRoute("application_index");
        }

        return $this->redirect($menus[0]["route"]);
    }
}
