<?php

namespace Front\AppBundle\Controller;

use Front\AppBundle\Entity\Application;
use Front\AppBundle\Services\ApplicationConnectionLogger;
use Front\AppBundle\Services\ApplicationGetter;
use Front\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApplicationsController extends Controller
{
    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @param ApplicationGetter $applicationGetter
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(ApplicationGetter $applicationGetter)
    {
        $applications               = $applicationGetter->getApplicationAccessible($this->getUser());
        $applicationsNotAccessible  = $applicationGetter->getApplicationNotAccessible($applications);

        return $this->render('FrontAppBundle:Applications:index.html.twig', array(
            "applications" => $applications,
            "applicationsNotAccessible" => $applicationsNotAccessible
        ));
    }

    /**
     * @Security("has_role('IS_AUTHENTICATED_FULLY')")
     * @param Application $application
     * @param ApplicationConnectionLogger $applicationConnectionLogger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getAction(Application $application, ApplicationConnectionLogger $applicationConnectionLogger) {
        $applicationConnectionLogger->logAccess($application, $this->getUser());
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
        /** @var User $user */
        $user = $this->getUser();

        return $this->redirect("http://vanina/external_access.php?login=".$user->getUsername() ."&application=".$application->getCode()."&password=$key");
    }
}
