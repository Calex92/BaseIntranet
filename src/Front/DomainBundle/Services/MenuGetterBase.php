<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/02/2017
 * Time: 16:51
 */

namespace Front\DomainBundle\Services;


use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

abstract class MenuGetterBase
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorization_checker;
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * MenuGetter constructor.
     * @param AuthorizationCheckerInterface $authorization_checker
     * @param RouterInterface $router
     */
    public function __construct(AuthorizationCheckerInterface $authorization_checker, RouterInterface $router)
    {
        $this->authorization_checker = $authorization_checker;
        $this->router = $router;
    }
}
