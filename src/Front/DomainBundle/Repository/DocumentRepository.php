<?php

namespace Front\DomainBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * DocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentRepository extends EntityRepository
{
    public function getActiveDocument($domain) {
        $qb = $this->createQueryBuilder("document_repository");
        if ($domain != "all") {
            $qb->where("domain.labelSimplified = :domain")
                ->setParameter("domain", $domain);
        }
        return $qb->andWhere("domain.active = :active")
            ->setParameter("active", true)
            ->leftJoin("document_repository.domain", "domain")
            ->orderBy("document_repository.creationDate", "DESC")
            ->getQuery()
            ->getResult();
    }
}