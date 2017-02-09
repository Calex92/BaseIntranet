<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 15/12/2016
 * Time: 10:51
 */

namespace Admin\UserManagerBundle\Service\JsonGenerator;


use Doctrine\ORM\EntityManager;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Entity\UserAgency;

class AgenciesForAjaxCall
{
    /** @var EntityManager $em */
    private $em;

    /**
     * AgenciesForAjaxCall constructor.
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * This function is used to generate the JSON sent back to the AJAX call when we manage the agencies
     * from one user. For every modification (add,update,remove) the response is the same: the list updated.
     *
     * @param integer $idUser The id of the user we've just updated
     * @return string The Json generated for the response
     */
    public function generateJsonForAjaxAgencies($idUser) {
        $agenciesForUser = $this->em->getRepository("FrontAppBundle:Agency")->getAgenciesNotUser($idUser);

        $json_response = '{"user_agency": [';

        $i = 0;
        $user_agencies = $this->em->getRepository("FrontAppBundle:UserAgency")->getFromUser($idUser);
        $len = count($user_agencies);
        foreach ($user_agencies as $user_agency) {
            /** @var UserAgency $user_agency */
            $json_response .= $user_agency->getJson();
            if ($i !== $len - 1) {
                $json_response .= ',';
            }
            $i++;
        }

        $json_response .= '], "agencies" : [';
        $i = 0;
        $len = count($agenciesForUser);
        foreach ($agenciesForUser as $agency) {
            /** @var Agency $agency */
            $json_response .= $agency->getJson();

            if ($i !== $len - 1) {
                $json_response .= ',';
            }
            $i++;
        }
        $json_response .= ']}';
        return $json_response;
    }
}
