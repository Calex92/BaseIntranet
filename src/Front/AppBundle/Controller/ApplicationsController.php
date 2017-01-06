<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        $applications = $this->get("frontapp.application_getter")->getAllApplication($this->getUser());

        return $this->render('FrontAppBundle:Applications:index.html.twig', array("applications" => $applications));
    }

    public function externalAccessAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository("FrontAppBundle:ApplicationExternal")->find($applicationId);
        $key = $this->get("frontapp.application_getter")->getCryptedKey();

        return $this->redirect("http://vanina/external_access.php?login=acastelain&application=".$application->getUniqueIdentifier()."&password=$key");
    }
}