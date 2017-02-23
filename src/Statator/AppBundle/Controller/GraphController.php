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
        $userByApplication = $this->get("statator_app.graph_generator.user_by_application")->generate();
        $browserComparisonChart = $this->get("statator_app.graph_generator.browser_comparison")->generate();

        return $this->render("@StatatorApp/Graph/index.html.twig", array(
            'userByApplication' => $userByApplication,
            'browserComparisonChart'    => $browserComparisonChart
        ));
    }
}