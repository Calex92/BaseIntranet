<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 01/02/2017
 * Time: 09:34
 */

namespace HelpReferentiel\AppBundle\Twig;


use HelpReferentiel\AppBundle\Services\MenuGetter;

class HelpReferentielAppTwigExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction("getMenusHelpReferentielApp", array($this, "getMenusHelpReferentielApp")),
        );
    }

    public function getMenusHelpReferentielApp ($currentRoute) {
        return $this->menuGetter->getMenus($currentRoute);
    }
}
