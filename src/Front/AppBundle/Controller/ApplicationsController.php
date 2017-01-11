<?php

namespace Front\AppBundle\Controller;

use Front\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    public function indexAction()
    {
        try {
            $applications = $this->get("frontapp.application_getter")->getAllApplication($this->getUser());
        } catch (\Exception $e) {
            $applications = array();
            $this->addFlash("danger", "Votre login ne correspond à aucun utilisateur sur l'ancien Isidore");
        }

        return $this->render('FrontAppBundle:Applications:index.html.twig', array("applications" => $applications));
    }

    public function externalAccessAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository("FrontAppBundle:ApplicationExternal")->find($applicationId);
        $key = $this->get("frontapp.application_getter")->getCryptedKey();

        return $this->redirect("http://vanina/external_access.php?login=acastelain&application=".$application->getUniqueIdentifier()."&password=$key");
    }
}