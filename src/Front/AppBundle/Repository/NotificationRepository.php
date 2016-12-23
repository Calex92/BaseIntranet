<?php

namespace Front\AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserNotification($idUser, $isSeen = NULL)
    {
        $qb = $this->getUserNotificationQueryBuilder($idUser);

        if ($isSeen !== NULL) {
            $qb->andWhere("notification_repository.seen = :isSeen")
                ->setParameter("isSeen", $isSeen);
        }

        return $qb->getQuery()
            ->getResult();
    }

    public function getPaginator ($idUser, $page, $nbPerPage) {
        $qb = $this->getUserNotificationQueryBuilder($idUser);

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query);
    }

    /**
     * @param $idUser
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getUserNotificationQueryBuilder($idUser) {
        $qb = $this->createQueryBuilder("notification_repository")
            ->join("notification_repository.user", "user")
            ->where("user.id = :idUser")
            ->setParameter("idUser", $idUser)
            ->orderBy("notification_repository.creationDate", "DESC");

        return $qb;
    }
}