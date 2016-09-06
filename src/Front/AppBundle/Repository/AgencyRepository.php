<?php

namespace Front\AppBundle\Repository;

/**
 * AgencyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgencyRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAgencies() {
        return $this->createQueryBuilder('agency_repository')
            ->where('agency_repository.active = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * This method is used to know the agencies that are not tied to an existing user.
     *
     * @param $idUser
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAgenciesNotUserQuery($idUser) {

        //First query, it get the id agencies that are linked to the user
        $subQb = $this->getEntityManager()->createQueryBuilder();
        $subQuery = $subQb
            ->select(['agency.id'])
            ->from("FrontAppBundle:UserAgency", "user_agency")
            ->innerJoin("user_agency.user", "user")
            ->innerJoin("user_agency.agency", "agency")
            ->where("user.id = :id")
            ->setParameter("id", $idUser)
            ->getQuery()
            ->getResult();

        //Then, I only take the one that are not in the list
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb
            ->select(["agency"])
            ->from('FrontAppBundle:Agency', "agency");

        if (count($subQuery) > 0) {
            $query->where($qb->expr()->notIn("agency.id", ":subQuery"))
                ->setParameter("subQuery", $subQuery);
        }

        return $query;
    }
}