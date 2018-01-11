<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 15:46
 */

namespace Statator\AppBundle\Services\GraphGenerator;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use Doctrine\ORM\EntityManagerInterface;

class BrowserComparison
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * UserByApplication constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate($numberMonthsToGenerate) {
        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable(
            $this->generateValues($numberMonthsToGenerate)
        );

        $chart->getOptions()
            ->setHeight(200)
            ->setWidth(600)
            ->getVAxis()
                ->setFormat('decimal');

        return $chart;
    }

    private function generateValues($numberMonthsToGenerate) {
        $values = $this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getComparisonBrowser($numberMonthsToGenerate);

        $datas[] = array("Navigateur", "Nombre");
        foreach ($values as $value) {
            $datas[] = array($value["browser"], intval($value["number_connection"]));
        }

        return $datas;
    }
}
