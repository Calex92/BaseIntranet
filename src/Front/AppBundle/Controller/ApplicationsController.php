<?php

namespace Front\AppBundle\Controller;

use Front\AppBundle\Entity\Application;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $applications               = $this->get("frontapp.application_getter")->getApplicationAccessible($this->getUser());
        $applicationsNotAccessible  = $this->get("frontapp.application_getter")->getApplicationNotAccessible($applications);

        return $this->render('FrontAppBundle:Applications:index.html.twig', array(
            "applications" => $applications,
            "applicationsNotAccessible" => $applicationsNotAccessible
        ));
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @param Application $application
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getAction(Application $application) {
        $this->get("frontapp.application_connection_statistics")->logAccess($application, $this->getUser());
        return $this->redirectToRoute($application->getLocation(), array("applicationId" => $application->getId()));
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @param $applicationId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function externalAccessAction($applicationId)
    {
        $application = $this->getDoctrine()->getRepository("FrontAppBundle:ApplicationExternal")->find($applicationId);
        $key = $this->get("frontapp.application_getter")->getCryptedKey();

        return $this->redirect("http://vanina/external_access.php?login=acastelain&application=".$application->getCode()."&password=$key");
    }
}
