<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 13/01/2017
 * Time: 14:54
 */

namespace Front\AppBundle\Controller;


use Doctrine\ORM\NoResultException;
use Front\AppBundle\Entity\Profile;
use Front\AppBundle\Entity\ProfilePrefered;
use Front\AppBundle\Services\ApplicationConnectionLogger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfilePreferedController extends Controller
{
    /**
     * This method remove the old ProfilesPrefered from the same app of the user and create a new one with the new profile given in parameter
     * @Security("has_role('IS_AUTHENTICATED_REMEMBERED')")
     * @param Profile $profile
     * @param ApplicationConnectionLogger $applicationConnectionLogger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeProfileAction(Profile $profile, ApplicationConnectionLogger $applicationConnectionLogger) {
        $em = $this->getDoctrine()->getManager();

        try {
            //Get the preferedProfile for this app & user
            $profilePrefered = $this->getDoctrine()->getRepository("FrontAppBundle:ProfilePrefered")->findByApplicationAndUser($profile->getApplication()->getId(), $this->getUser()->getId());
            //Set the new profile
            $profilePrefered->setProfile($profile);
        }
        catch (NoResultException $e) {
            //This exception is thrown is there's no result for the query so we create a new ProfilePrefered
            $profilePrefered = new ProfilePrefered();
            $profilePrefered->setApplication($profile->getApplication())
                ->setProfile($profile)
                ->setUser($this->getUser());

            $em->persist($profilePrefered);
        }
        //Save it in DB
        $em->flush();
        $applicationConnectionLogger->logAccess($profile->getApplication(), $this->getUser());
        //Redirect to the route of the app
        return $this->redirectToRoute($profile->getApplication()->getLocation());
    }
}
