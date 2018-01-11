<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/02/2017
 * Time: 14:08
 */

namespace Statator\AppBundle\Services\GraphGenerator;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Front\AppBundle\Entity\Application;

class UserByApplication
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;
    const NUMBER_MONTH_TO_DISPLAY = 2;

    /**
     * UserByApplication constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generate a graph based on the GoogleGraph library
     * @return ColumnChart
     */
    public function generate() {
        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable(
            $this->generateValues()
        );

        $chart->getOptions()
            ->setBars('horizontal')
            ->setHeight(600)
            ->setWidth(600)
            ->getVAxis()
                ->setFormat('decimal');

        return $chart;
    }

    /**
     * Generate the values used in the graph
     * @return array
     */
    private function generateValues() {
        /* Get the applications for which we'll have to generate the values */
        $applications = $this->entityManager
            ->getRepository("FrontAppBundle:Application")->findBy(array(), array("name" => "ASC"));

        /* Then get the dates we'll have to use */
        $thisMonth = new DateTime();
        $valuesThisMonth = $this->checkLenghtArray($this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountUserByApplication($thisMonth->format("m"), $thisMonth->format("Y")), $applications);

        $lastMonth = new DateTime("last month");
        $valuesLastMonth = $this->checkLenghtArray($this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountUserByApplication($lastMonth->format("m"), $lastMonth->format("Y")), $applications);

        $twoMonthsAgo = new DateTime("-2 months");
        $valuesTwoMonthsAgo = $this->checkLenghtArray($this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountUserByApplication($twoMonthsAgo->format("m"), $twoMonthsAgo->format("Y")), $applications);

        $threeMonthsAgo = new DateTime("-3 months");
        $valuesThreeMonthsAgo = $this->checkLenghtArray($this->entityManager
            ->getRepository("FrontAppBundle:ApplicationConnectionStatistics")
            ->getCountUserByApplication($threeMonthsAgo->format("m"), $threeMonthsAgo->format("Y")), $applications);

        /* On windows it displays in english but in Linux it's in french, if not, check if the locale is
            french in the php.ini */
        $titles = array("Applications",
            strftime("%B", $thisMonth->getTimestamp()),
            strftime("%B", $lastMonth->getTimestamp()),
            strftime("%B", $twoMonthsAgo->getTimestamp()),
            strftime("%B", $threeMonthsAgo->getTimestamp())
        );

        $values = $this->generateData(array(
            $valuesThisMonth,
            $valuesLastMonth,
            $valuesTwoMonthsAgo,
            $valuesThreeMonthsAgo),
            $applications);

        /* We add the titles to the values */
        array_unshift($values,
            $titles);

        return $values;
    }

    /**
     * If we get a value that's not set for an app, we add 0 for it
     * @param array $stats
     * @param array $applications
     * @return array
     */
    private function checkLenghtArray(array $stats, array $applications) {
        foreach ($applications as $application) {
            /** @var Application $application */
            $isInList = false;
            foreach ($stats as $stat) {
                if ($stat["application_code"] == $application->getCode()) {
                    $isInList = true;
                    break;
                }
            }

            if (!$isInList) {
                $stats[] = array(
                    "number_user" => 0,
                    "application_code" => $application->getCode()
                );
            }
        }
        return $stats;
    }

    /**
     * Format the datas for the graph
     * @param array $datas
     * @param $applications
     * @return array
     */
    private function generateData(array $datas, $applications) {
        $array = array();
        //We need the datas for each application.
        foreach ($applications as $application) {
            /** @var Application $application */
            $values = array();
            foreach ($datas as $data) {
                foreach ($data as $element) {
                    if ($element["application_code"] == $application->getCode()) {
                        $values[] = intval($element["number_user"]);
                    }
                }
            }

            if (empty($values)) {
                for ($i = 0; $i < count($datas); $i++) {
                    $values[] = 0;
                }
            }
            array_unshift($values, $application->getName());
            $array [] = $values;
        }
        return $array;
    }
}
