<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/01/2017
 * Time: 14:38
 */

namespace Front\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelpController extends Controller
{
    public function indexAction() {
        return $this->render("FrontAppBundle:Help:index.html.twig");
    }
}