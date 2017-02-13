<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/01/2017
 * Time: 14:38
 */

namespace Front\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelpController extends Controller
{
    public function indexAction() {
        $applications = $this->getDoctrine()->getRepository("FrontAppBundle:Application")->findBy(array(), array("name" => "ASC"));
        return $this->render("FrontAppBundle:Help:index.html.twig", array(
            "applications"   => $applications
        ));
    }
}
