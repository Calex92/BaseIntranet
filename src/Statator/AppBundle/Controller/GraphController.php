<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 12:07
 */

namespace Statator\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GraphController extends Controller
{
    public function indexAction() {
        return $this->render("@StatatorApp/Graph/index.html.twig");
    }
}