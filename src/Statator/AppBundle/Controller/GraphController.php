<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 12:07
 */

namespace Statator\AppBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Front\AppBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GraphController extends Controller
{
    const NUMBER_MONTHS_BROWSER_COMPARISON = 6;
    public function indexAction() {
        $userByApplication = $this->get("statator_app.graph_generator.user_by_application")->generate();
        $browserComparisonChart = $this->get("statator_app.graph_generator.browser_comparison")->generate(self::NUMBER_MONTHS_BROWSER_COMPARISON);

        return $this->render("@StatatorApp/Graph/index.html.twig", array(
            'userByApplication' => $userByApplication,
            'browserComparisonChart'    => $browserComparisonChart,
            'numberMonthsBrowserComparison' => self::NUMBER_MONTHS_BROWSER_COMPARISON
        ));
    }

    public function applicationAction(Application $application) {
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [
                ['Pac Man', 'Percentage'],
                ['Jean', 75],
                ['Paul', 25],
                ['Pierre', 30]
            ]
        );
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(900);

        return $this->render("StatatorAppBundle:Graph:applicationAdmin.html.twig", array(
            "pieChart"          => $pieChart,
            "applicationName"   => $application->getName()
        ));
    }
}
