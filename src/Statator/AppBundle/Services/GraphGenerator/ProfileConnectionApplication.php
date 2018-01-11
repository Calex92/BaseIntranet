<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/02/2017
 * Time: 17:57
 */

namespace Statator\AppBundle\Services\GraphGenerator;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Front\AppBundle\Entity\Application;

class ProfileConnectionApplication
{
    private $entityManager;

    /**
     * ProfileConnectionApplication constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate(Application $application, $numberMonthToDisplay) {
        $values = $this->generateValues($application, $numberMonthToDisplay);
        array_unshift($values, array("Profil", "Numbre de connection"));

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            $values
        );
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(900);

        return $pieChart;
    }

    private function generateValues(Application $application, $numberMonthToDisplay) {
        $values = $this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountByProfile($application, $numberMonthToDisplay);

        foreach ($values as &$value) {
            $value["number_profile"] = intval($value["number_profile"]);
        }

        return $values;
    }
}
