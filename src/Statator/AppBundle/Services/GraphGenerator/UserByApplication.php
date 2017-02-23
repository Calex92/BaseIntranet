<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 14:08
 */

namespace Statator\AppBundle\Services\GraphGenerator;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use Doctrine\ORM\EntityManager;

class UserByApplication
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    const NUMBER_MONTH_TO_DISPLAY = 2;

    /**
     * UserByApplication constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ColumnChart
     */
    public function generate() {
        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable(
            $this->generateValues()
        );

        $chart->getOptions()
            ->setBars('horizontal')
            ->setHeight(200)
            ->setWidth(600)
            ->getVAxis()
                ->setFormat('decimal');

        return $chart;
    }

    private function generateValues() {
        $values = $this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountUserByApplication();

        $datas[] = array("Applications", "Janvier", "Février");

        $lastApplication = "";
        $valueIHaveToAdd = array();
        foreach ($values as $value) {
            if ($lastApplication != $value["application_name"]) {
                if ($valueIHaveToAdd != array())
                    $datas[] = $this->checkLenghtArray($valueIHaveToAdd);
                $valueIHaveToAdd = array($value["application_name"], intval($value["number_user"]));
                $lastApplication = $value["application_name"];
            }
            else {
                $valueIHaveToAdd[] = intval($value["number_user"]);
            }
        }
        $datas[] = $this->checkLenghtArray($valueIHaveToAdd);
        return $datas;
    }

    private function checkLenghtArray(array $array) {
        while (count($array) < (self::NUMBER_MONTH_TO_DISPLAY+1)) {
            $array[] = 0;
        }
        return $array;
    }
}
