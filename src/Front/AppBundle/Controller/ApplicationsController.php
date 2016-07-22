<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        $applications = $this->getDoctrine()->getRepository("FrontAppBundle:Application")->findAll();

        return $this->render('FrontAppBundle:Applications:index.html.twig', array("applications" => $applications));
    }
}
