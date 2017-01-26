<?php

namespace Front\DomainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Front\UserBundle\Entity\User;

/**
 * newsDomainRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DomainRepository extends EntityRepository
{
    public function getActiveQueryBuilder(User $user)
    {
        $qb = $this->createQueryBuilder('domain_repository');
        $qb = $qb
            ->where($qb->expr()->eq("domain_repository.active", true));

        if (in_array("ROLE_DOMAIN_ADMIN", $user->getRoles())) {
            $qb->andWhere($qb->expr()->in('domain_repository.role', $user->getRoles()));
        }

        return $qb;
    }

    /**
     * @param string $metadataClass
     * @return array
     */
    public function getActiveWithChildren($metadataClass = NULL)
    {
        $em = $this->getEntityManager();
        $qb = $this->createQueryBuilder('domain_repository');
        $qb->join("domain_repository.domainElements", "domain_elements")
            ->where("domain_elements.endPublicationDate >= :dateToday")
            ->orWhere($qb->expr()->isNull("domain_elements.endPublicationDate"))
            ->andWhere($qb->expr()->eq("domain_repository.active", true))
            ->andWhere("domain_elements.beginPublicationDate <= :dateToday")
            ->setParameter("dateToday", new \DateTime());

        if ($metadataClass != NULL) {
            $qb->andWhere("domain_elements INSTANCE OF :class")
                ->setParameter("class", $em->getClassMetadata($metadataClass));
        }

        return $qb
            ->orderBy("domain_repository.label")
            ->getQuery()
            ->getResult();
    }
}
