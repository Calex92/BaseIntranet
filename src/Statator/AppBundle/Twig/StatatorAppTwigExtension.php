<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/02/2017
 * Time: 09:34
 */

namespace Statator\AppBundle\Twig;


use Statator\AppBundle\Services\MenuGetter;

class StatatorAppTwigExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction("getMenusStatatorApp", array($this, "getMenusStatatorApp")),
        );
    }

    public function getMenusStatatorApp ($currentRoute) {
        return $this->menuGetter->getMenus($currentRoute);
    }
}
