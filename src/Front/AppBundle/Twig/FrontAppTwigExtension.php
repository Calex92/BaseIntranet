<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 23/12/2016
 * Time: 09:37
 */

namespace Front\AppBundle\Twig;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Front\AppBundle\Entity\Profile;
use Front\AppBundle\Services\MenuGetter;
use Front\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FrontAppTwigExtension extends \Twig_Extension
{
    /** @var  EntityManagerInterface */
    private $entityManager;
    private $tokenStorage;
    /** @var  MenuGetter */
    private $menuGetter;

    /**
     * FrontAppExtension constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param MenuGetter $menuGetter
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        MenuGetter $menuGetter
    ) {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
        $this->menuGetter       = $menuGetter;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction("userUnreadMessage", array($this, "userUnreadMessage")),
            new \Twig_SimpleFunction("getProfileByApplicationName", array($this, "getProfileByApplicationName")),
            new \Twig_SimpleFunction("getMenusFrontApp", array($this, "getMenusFrontApp")),
        );
    }

    public function userUnreadMessage() {
        if (null === $token = $this->tokenStorage->getToken()) {
            return 0;
        }

        $user = $token->getUser();
        $notifications = $this->entityManager
            ->getRepository("FrontAppBundle:Notification")
            ->getUserNotification($user, false);
        return $notifications;
    }

    public function getProfileByApplicationName($applicationCode) {
        if (null === $token = $this->tokenStorage->getToken()) {
            return array();
        }
        /** @var User $user */
        $profiles = $token->getUser()->getProfilesApplication();
        $profilesFromApp = new ArrayCollection();
        foreach ($profiles as $profile) {
            /** @var Profile $profile */
            if ($profile->getApplication()->getCode() == $applicationCode) {
                $profilesFromApp->add($profile);
            }
        }
        return $profilesFromApp->toArray();
    }

    public function getMenusFrontApp ($currentRoute) {
        return $this->menuGetter->getMenus($currentRoute);
    }

    public function getName()
    {
        return 'front_app_twig_extension';
    }
}
