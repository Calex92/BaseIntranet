<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 02/09/2016
 * Time: 14:02
 */

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * Class UserAgency
 * @package Front\AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\UserAgencyRepository")
 * @ORM\Table(name="user_agency")
 */
class UserAgency
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="state", type="boolean")
     */
    private $principal;

    /**
     * @ORM\ManyToOne(targetEntity="Front\UserBundle\Entity\User", inversedBy="user_agencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Agency", inversedBy="user_agencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agency;

    /**
     * UserAgency constructor.
     * @param $user
     * @param $agency
     * @param $principal boolean User to know if this is the main agency or not
     */
    public function __construct(User $user, Agency $agency, $principal = false)
    {
        $this->user = $user;
        $this->agency = $agency;
        $this->principal = $principal;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * @param mixed $principal
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }


    public function getJson() {
        $json_response = '{';
        $json_response .= '"idUser_Agency" : "'. $this->getId() . '",';
        $json_response .= '"idAgency" : "'. $this->getAgency()->getId(). '",';
        $json_response .= '"codeAgency" : "'. $this->getAgency()->getCode(). '",';
        $json_response .= '"principale" : "'. $this->getPrincipal(). '",';
        $json_response .= '"nameAgency" : "'. addslashes($this->getAgency()->getName()) . '"';
        $json_response .= '}';

        return $json_response;
    }
    
}