<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/01/2017
 * Time: 14:51
 */

namespace HelpReferentiel\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RequestController extends Controller
{
    public function indexAction() {
        return $this->render("HelpReferentielAppBundle:Request:index.html.twig");
    }
}
