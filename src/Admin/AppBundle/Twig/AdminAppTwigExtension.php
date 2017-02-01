<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/02/2017
 * Time: 09:41
 */

namespace Admin\AppBundle\Twig;


use Admin\AppBundle\Services\MenuGetter;

class AdminAppTwigExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction("getMenusAdminApp", array($this, "getMenusAdminApp")),
        );
    }

    public function getMenusAdminApp ($currentRoute) {
        return $this->menuGetter->getMenus($currentRoute);
    }
}
