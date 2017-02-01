<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/02/2017
 * Time: 09:15
 */

namespace Front\DomainBundle\Twig;


use Front\DomainBundle\Services\MenuGetter;

class FrontDomainTwigExtension extends \Twig_Extension
{
    /** @var MenuGetter */
    private $menuGetter;

    public function __construct(
        MenuGetter $menuGetter
    ) {
        $this->menuGetter       = $menuGetter;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction("getMenusFrontDomain", array($this, "getMenusFrontDomain")),
        );
    }

    public function getMenusFrontDomain ($currentRoute) {
        return $this->menuGetter->getMenus($currentRoute);
    }
}
