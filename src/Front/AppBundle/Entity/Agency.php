<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agency
 *
 * @ORM\Table(name="base_agency")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\AgencyRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"code", "name"},
 *     message="Ce champ est déjà utilisé par une autre agence"
 * )
 */
class Agency
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer", unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var double
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var double
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     *
     * @ORM\OneToOne(targetEntity="Front\AppBundle\Entity\Contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="text", nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="text", nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="text", nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\UserAgency", mappedBy="agency")
     */
    private $user_agencies;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Region", inversedBy="agencies")
     */
    private $region;

    /**
     * Agency constructor.
     */
    public function __construct()
    {
        $this->active = true;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserAgencies()
    {
        return $this->user_agencies;
    }

    /**
     * @param $user_agencies
     * @internal param mixed $user_Agencies
     */
    public function setUserAgencies($user_agencies)
    {
        $this->user_agencies = $user_agencies;
    }

    public function getUsers() {
        $users = array();
        foreach ($this->user_agencies as $user_agency) {
            if ($user_agency instanceof UserAgency)
                array_push($users, $user_agency->getUser());
        }
        return $users;
    }

    public function getJson() {
        $json_response = '{';
        $json_response .= '"idAgency" : "'. $this->getId() . '",';
        $json_response .= '"codeAgency" : "'. $this->getCode() . '",';
        $json_response .= '"nameAgency" : "'. addslashes($this->getName()) . '"';
        $json_response .= '}';

        return $json_response;
    }

    /**
     * Set number
     *
     * @param integer $code
     *
     * @return Agency
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Agency
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Agency
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Agency
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Agency
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Agency
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreationDateAtPersist() {
        $this->setCreationDate(new \DateTime());
    }

    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }


}

