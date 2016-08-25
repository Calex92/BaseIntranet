<?php
namespace Front\UserBundle\Handler;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class PasswordCheckerHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;
    protected $session;
    protected $numberMonth;

    public function __construct(Router $router, AuthorizationChecker $security, Session $session, $numberMonth)
    {
        $this->router = $router;
        $this->security = $security;
        $this->session = $session;
        $this->numberMonth = $numberMonth;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();

        $monthPasswordCreated = 0;
        if ($user->getLastPasswordChange() !== null) {
            $interval = date_diff(new \DateTime(), $user->getLastPasswordChange());
            $monthPasswordCreated = $interval->m + ($interval->y * 12);
        }

        //If the LastPasswordChange is not set it's because it's the first time the user connect to it's account
        //If he didn't changed his password before the last 3 months, the only page he will see will be the change
        //you password page
        if ($user->getLastPasswordChange() === null || $monthPasswordCreated > ($this->numberMonth-1)) {
            $this->session->getFlashBag()->add("danger", "Vous devez changer votre mot de passe tout les ".$this->numberMonth." mois!");
            return new RedirectResponse($this->router->generate("fos_user_change_password"));
        }

        // redirect the user to where they were before the login process begun.
        $referer_url = $request->headers->get('referer');

        return new RedirectResponse($referer_url);

    }

}