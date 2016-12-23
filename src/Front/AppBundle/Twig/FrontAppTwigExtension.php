<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 23/12/2016
 * Time: 09:37
 */

namespace Front\AppBundle\Twig;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FrontAppTwigExtension extends \Twig_Extension
{
    /** @var  EntityManager */
    private $entityManager;
    private $tokenStorage;

    /**
     * FrontAppExtension constructor.
     * @param $entityManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction("userUnreadMessage", array($this, "userUnreadMessage"))
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

    public function getName()
    {
        return 'front_app_twig_extension';
    }
}