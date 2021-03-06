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
     * @return array
     */
    public function findInternalApplication() {
        $qb = $this->createQueryBuilder("application");
        return $qb->where($qb->expr()
            ->isInstanceOf("application", Application::class))
            ->getQuery()
            ->getResult();
    }
}
