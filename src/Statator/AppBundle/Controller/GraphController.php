<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 12:07
 */

namespace Statator\AppBundle\Controller;

use Front\AppBundle\Entity\Application;
use Statator\AppBundle\Services\GraphGenerator\BrowserComparison;
use Statator\AppBundle\Services\GraphGenerator\ProfileConnectionApplication;
use Statator\AppBundle\Services\GraphGenerator\UserByApplication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GraphController extends Controller
{
    const NUMBER_MONTHS_BROWSER_COMPARISON = 6;
    const NUMBER_MONTHS_APPLICATION_PROFILE = 6;

    public function indexAction(UserByApplication $userByApplication, BrowserComparison $browserComparison) {
        $userByApplication = $userByApplication->generate();
        $browserComparisonChart = $browserComparison->generate(self::NUMBER_MONTHS_BROWSER_COMPARISON);

        return $this->render("@StatatorApp/Graph/index.html.twig", array(
            'userByApplication' => $userByApplication,
            'browserComparisonChart'    => $browserComparisonChart,
            'numberMonthsBrowserComparison' => self::NUMBER_MONTHS_BROWSER_COMPARISON
        ));
    }

    public function applicationAction(Application $application, ProfileConnectionApplication $profileConnectionApplication) {
        $applicationChart = $profileConnectionApplication
            ->generate($application, self::NUMBER_MONTHS_APPLICATION_PROFILE);

        return $this->render("StatatorAppBundle:Graph:application.html.twig", array(
            "applicationChart"          => $applicationChart,
            "applicationName"   => $application->getName(),
            "lastMonth"         => self::NUMBER_MONTHS_APPLICATION_PROFILE
        ));
    }
}
