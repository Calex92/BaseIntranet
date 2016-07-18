<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function newsAction()
    {
        return $this->render('FrontBundle:Main:news.html.twig');
    }

    public function documentsAction() {
        return $this->render("FrontBundle:Main:documents.html.twig");
    }

    public function sideMenuAction($position) {
        $menus = array();

        if ($position == "left") {
            $element["href"] = "#";
            $element["alt"] = "Catalogue Usinage";
            $element["src"] = "bundles/front/img/img-usinage_100.png";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Catalogue transmission";
            $element["src"] = "bundles/front/img/img-transmission_100.png";
            array_push($menus, $element);
        }
        else if ($position == "right") {
            $element["href"] = "#";
            $element["alt"] = "Arrivages Orexad n°2";
            $element["src"] = "bundles/front/img/pack2.png";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Bons plans 24";
            $element["src"] = "bundles/front/img/bp24.jpg";
            array_push($menus, $element);

            $element["href"] = "#";
            $element["alt"] = "Catalogue GISS";
            $element["src"] = "bundles/front/img/img_giss_catalogue.jpg";
            array_push($menus, $element);
        }


        return $this->render("FrontBundle:Main:sideMenu.html.twig", array("menus" => $menus));
    }
}
