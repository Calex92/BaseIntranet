<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-08-16
 * Time: 18:20
 */

namespace Front\UserBundle\EventListener;


use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class PasswordListener
{
    protected $userManager;
    private $router;


    public function __construct(UserManagerInterface $userManager, RouterInterface $router)
    {
        $this->userManager = $userManager;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        $monthPasswordCreated = 0;
        if ($user->getLastPasswordChange() !== null){
            $interval = date_diff(new \DateTime(), $user->getLastPasswordChange());
            $monthPasswordCreated = $interval->m + ($interval->y * 12);
        }

        //If the LastPasswordChange is not set it's because it's the first time the user connect to it's account
        //If he didn't changed his password before the last 3 months, the only page he will see will be the change
        //you password page
        if ($user->getLastPasswordChange() === null || $monthPasswordCreated > 2) {
            return new RedirectResponse($this->router->generate("fos_user_change_password"));
        }

        return new Response();
    }
}