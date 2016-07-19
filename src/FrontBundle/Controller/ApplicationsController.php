<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        $applications = array();

        $application = array("name" => "Administration Isidore",
            "location" => "download/front/applications/adminisidore.png",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Espaces Grands Comptes",
            "location" => "download/front/applications/espacegrandcompte.png",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Espace GISS",
            "location" => "download/front/applications/giss.jpg",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Helpdesk Référentiel",
            "location" => "download/front/applications/referentiel.png",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Omniview",
            "location" => "download/front/applications/omniview.jpg",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "E-learning",
            "location" => "download/front/applications/elearning.png",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Help ADV",
            "location" => "download/front/applications/HELP-ADV2.png",
            "href" => "#");
        array_push($applications, $application);

        $application = array("name" => "Book RE / DR",
            "location" => "download/front/applications/bookre.png",
            "href" => "#");
        array_push($applications, $application);

        return $this->render('@Front/Applications/index.html.twig', array("applications" => $applications));
    }
}
