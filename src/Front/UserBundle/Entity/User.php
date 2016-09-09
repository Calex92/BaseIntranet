<?php

namespace Front\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Entity\Image;
use Front\AppBundle\Entity\UserAgency;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="Front\UserBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     *
     * @ORM\OneToOne(targetEntity="Front\AppBundle\Entity\Contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $contact;

    /**
     * @ORM\OneToOne(targetEntity="Front\AppBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\UserAgency", mappedBy="user")
     */
    private $user_agencies;


    /**
     * @ORM\Column(name="lastPasswordChange", type="date", nullable=true)
     */
    private $lastPasswordChange;

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
     * @param mixed $user_agencies
     */
    public function setUserAgency($user_agencies)
    {
        $this->user_agencies = $user_agencies;
    }

    public function getAgencies() {
        $agencies = array();
        foreach ($this->user_agencies as $user_agency) {
            if ($user_agency instanceof UserAgency)
                array_push($agencies, $user_agency->getAgency());
        }
        return $agencies;
    }
    /**
     * Set name
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    public function getContact()
    {
        return $this->contact;
    }
    
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getLastPasswordChange()
    {
        return $this->lastPasswordChange;
    }

    /**
     * @param mixed $lastPasswordChange
     */
    public function setLastPasswordChange($lastPasswordChange)
    {
        $this->lastPasswordChange = $lastPasswordChange;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prepareObjectPersist() {
        if ($this->image == null) {
            //The user need his basic profile picture and need to be activated.
            //This is just done before the user is added in the database.
            $image = new Image();
            $image->setAlt("My profile picture");
            $image->setUrl("bundles/frontuser/img/basic_avatar.png");

            $this->setEnabled(true);
            $this->setImage($image);
        }
    }

    public function addAgency (Agency $agency, $primary) {
        $user_agency = new UserAgency($this, $agency, $primary);

        $this->user_agencies[] = $user_agency;
    }
}

