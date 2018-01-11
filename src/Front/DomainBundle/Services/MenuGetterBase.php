<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/02/2017
 * Time: 16:51
 */

namespace Front\DomainBundle\Services;


use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

abstract class MenuGetterBase
{
    /**
     * @var AuthorizationChecker
     */
    protected $authorization_checker;
    /**
     * @var Router
     */
    protected $router;

    /**
     * MenuGetter constructor.
     * @param AuthorizationChecker $authorization_checker
     * @param Router $router
     */
    public function __construct(AuthorizationChecker $authorization_checker, Router $router)
    {
        $this->authorization_checker = $authorization_checker;
        $this->router = $router;
    }
}
