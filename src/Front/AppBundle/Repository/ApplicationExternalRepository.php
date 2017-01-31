<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/11/2016
 * Time: 14:27
 */

namespace Front\AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ApplicationExternalRepository extends EntityRepository
{
    /**
     * @param array $externalAppsCode
     * @return array
     */
    public function getUserApplication(array $externalAppsCode) {
        $qb = $this->createQueryBuilder("application_external_repository");

        $qb->where($qb->expr()->in("application_external_repository.code", $externalAppsCode));

         return $qb->getQuery()->getResult();
    }
}
