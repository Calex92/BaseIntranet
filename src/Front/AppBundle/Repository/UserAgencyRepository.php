<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 07/09/2016
 * Time: 10:19
 */

namespace Front\AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Front\AppBundle\Entity\UserAgency;
use Front\UserBundle\Entity\User;

class UserAgencyRepository extends EntityRepository
{
    /**
     * This method is used to add a agency to a user. Or add a user to an agency.
     * @param $idUser
     * @param $idAgency
     * @return array If there's an error, the array will contain the "message" with the "code" of the error. If there's no
     * problem, the array contains the "user_agency" newly added and the code.
     */
    public function addUserAgency($idUser, $idAgency) {
        $entityManager = $this->getEntityManager();

        $user = $entityManager->getRepository("FrontUserBundle:User")->find(array("id" => $idUser));
        $agency = $entityManager->getRepository("FrontAppBundle:Agency")->find(array("id" => $idAgency));

        //If the user or the agency is not found in DB
        if (!isset($user) || !isset($agency)) {
            return array("message" => "L'utilisateur d'id " . $idUser . " ou l'agence d'id " . $idAgency . " n'ont pas été trouvés
                                        en base de données, veuillez vérifier la cohérence des information et tenter à nouveau
                                        l'ajout.");
        } //If the user already got the agency in his list
        else if (in_array($agency, $user->getAgencies())) {
            return array("message" => "L'utilisateur " . $user->getUsername() .
                " appartient déjà à l'agence " . $agency->getCode() . " " . $agency->getName() . ".");
        }
        $user_agency = new UserAgency($user, $agency);

        //This is not yet saved in DB, so the number of Agencies is equals to 0 instead of 1
        if (count($user_agency->getUser()->getAgencies()) == 0) {
            $user_agency->setPrincipal(true);
        }

        $entityManager->persist($user_agency);
        $entityManager->flush();

        return array("user_agency" => $user_agency);

    }

    public function removeUserAgency($idUserAgency)
    {
        $entityManager = $this->getEntityManager();

        $userAgency = $this->getFromUserAndAgency($idUserAgency);

        if (!isset($userAgency)) {
            return array("message" => "Impossible de trouver de lien en base de données entre cet utilisateur et cette agence.");
        }
        else if ($userAgency->getPrincipal()) {
            return array("message" => "Impossible de supprimer l'agence " . $userAgency->getAgency()->getName() . " car c'est l'agence
                                        principale de l'utilisateur. Veuillez définir une autre agence avant de supprimer celle-ci");
        }

        $entityManager->remove($userAgency);
        $entityManager->flush();

        return array("agency" => $userAgency->getAgency());
    }

    public function getFromUserAndAgency($idUserAgency)
    {
        $entityManager = $this->getEntityManager()
            ->find("FrontAppBundle:UserAgency", array("id" => $idUserAgency));

        return $entityManager;
    }

    public function setAsPrincipal($idUserAgency) {
        $entityManager = $this->getEntityManager();

        $userAgency = $this->getFromUserAndAgency($idUserAgency);

        if (!isset($userAgency)) {
            return array("message" => "Impossible de trouver l'agence de cet utilisateur dans la base de données");
        }
        else if ($userAgency->getPrincipal()) {
            return array("message" => "Cette agence est déjà selectionnée comme étant principale");
        }

        /** @var User $user */
        $user = $userAgency->getUser();
        foreach ($user->getUserAgencies() as $userAgencyLoop) {
            /** @var UserAgency $userAgencyLoop */
            if ($userAgencyLoop->getPrincipal()) {
                $userAgencyLoop->setPrincipal(false);
                $entityManager->flush($userAgencyLoop);
            }
        }

        $userAgency->setPrincipal(true);
        $entityManager->flush($userAgency);


        return array("user_agency" => $userAgency);
    }
}