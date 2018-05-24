<?php

namespace Statator\AppBundle\Controller;

use Statator\AppBundle\Services\MenuGetter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction(MenuGetter $menusGetter) {
        $menus = $menusGetter->getMenus("");

        if (count($menus) == 0) {
            $this->addFlash("danger", "Vous n'avez aucun menu actif via votre profil sur cette application, veuillez contacter OI");
            return $this->redirectToRoute("application_index");
        }

        return $this->redirect($menus[0]["route"]);
    }
}
