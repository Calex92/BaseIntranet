<?php

namespace Front\DomainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CatalogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CatalogRepository extends EntityRepository
{
    public function getFromSide($isLeft)
    {
        $qb = $this->createQueryBuilder("catalog_repository");

        return $qb->where("catalog_repository.isPositionLeft = :isLeft")
            ->setParameter("isLeft", $isLeft)
            ->andWhere("catalog_repository.beginPublicationDate < :today")
            ->setParameter("today", new \DateTime())
            ->andWhere("catalog_repository.visible = :isVisible")
            ->setParameter("isVisible", true)
            ->orderBy("catalog_repository.beginPublicationDate", "DESC")
            ->getQuery()
            ->getResult();
    }

    public function getPaginator($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder("catalog_repository")
            ->getQuery()
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query);
    }
}
