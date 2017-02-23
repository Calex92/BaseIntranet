<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 15:46
 */

namespace Statator\AppBundle\Services\GraphGenerator;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use Doctrine\ORM\EntityManager;

class BrowserComparison
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /**
     * UserByApplication constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate() {
        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable(
            $this->generateValues()
        );

        $chart->getOptions()
            ->setHeight(200)
            ->setWidth(600)
            ->getVAxis()
                ->setFormat('decimal');

        return $chart;
    }

    private function generateValues() {
        $values = $this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getComparisonBrowser();

        $datas[] = array("Navigateur", "Nombre");
        foreach ($values as $value) {
            $datas[] = array($value["browser"], intval($value["number_connection"]));
        }

        return $datas;
    }
}
