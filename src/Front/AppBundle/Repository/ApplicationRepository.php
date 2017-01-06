<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/11/2016
 * Time: 14:27
 */

namespace Front\AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Front\AppBundle\Entity\Application;

class ApplicationRepository extends EntityRepository
{
    /**
     * This methods sends back every application the user need to have. It looks though the internal and external apps
     * @param array $externalAppsCode
     * @return array
     */
    public function getUserApplication(array $externalAppsCode) {
        $em = $this->getEntityManager();
        //first, get our apps
        $applications = $this->createQueryBuilder("application_repository")
            ->where("application_repository INSTANCE OF :class")
            ->setParameter("class", $em->getClassMetadata("FrontAppBundle:Application"))
            ->getQuery()
            ->getResult();
        //then, get external apps
        $externalApplications = $em->getRepository("FrontAppBundle:ApplicationExternal")->getUserApplication($externalAppsCode);

        $applications = array_merge($applications, $externalApplications);
        //sort alphabetically
        uasort($applications, function($a, $b) {
            /** @var $a Application */
            /** @var $b Application */
            return strcmp($a->getName(), $b->getName());
        });

        return $applications;
    }
}