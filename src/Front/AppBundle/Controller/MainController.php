<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class MainController extends Controller
{
    public function sideMenuAction($position) {
        $menus = array();

        if ($position == "left") {
            $element["href"] = "#";
            $element["alt"] = "Catalogue Usinage";
            $element["src"] = "bundles/frontapp/img/img-usinage_100.png";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Catalogue transmission";
            $element["src"] = "bundles/frontapp/img/img-transmission_100.png";
            array_push($menus, $element);
        }
        else if ($position == "right") {
            $element["href"] = "#";
            $element["alt"] = "Arrivages Orexad n°2";
            $element["src"] = "bundles/frontapp/img/pack2.png";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Bons plans 24";
            $element["src"] = "bundles/frontapp/img/bp24.jpg";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Catalogue GISS";
            $element["src"] = "bundles/frontapp/img/img_giss_catalogue.jpg";
            array_push($menus, $element);
        }


        return $this->render("@FrontApp/Main/sideMenu.html.twig", array("menus" => $menus));
    }
}
