<?php

namespace Front\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Entity\Group;
use Front\AppBundle\Entity\Profile;
use Front\AppBundle\Entity\ProfilePrefered;
use Front\AppBundle\Entity\Right;
use Front\DomainBundle\Entity\Domain;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Front\AppBundle\Entity\UserAgency;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="base_user")
 * @ORM\Entity(repositoryClass="Front\UserBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable()
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
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="imageName")
     *
     * @var File
     * @Assert\File(mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\UserAgency", mappedBy="user", cascade={"persist"})
     */
    private $user_agencies;

    /**
     * @ORM\Column(name="lastPasswordChange", type="date", nullable=true)
     */
    private $lastPasswordChange;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Group", inversedBy="users")
     */
    protected $group;

    /**
     * @var Collection[Profile]
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Profile", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="base_user_profile")
     */
    private $profiles;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\ProfilePrefered", mappedBy="user")
     */
    private $profilesPrefered;

    /**
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="Front\DomainBundle\Entity\Domain", inversedBy="users")
     */
    private $domainManaged;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->profiles = new ArrayCollection();
        $this->profilesPrefered = new ArrayCollection();
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
     * @return UserAgency
     */
    public function getAgencyPrincipal() {
        foreach ($this->user_agencies as $user_agency) {
            /** @var UserAgency $user_agency */
            if($user_agency->getPrincipal())
                return $user_agency;
        }
        return new UserAgency($this, new Agency());
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
        return $this;
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

    public function addAgency (Agency $agency, $primary) {
        $user_agency = new UserAgency($this, $agency, $primary);

        $this->user_agencies[] = $user_agency;
    }

    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return User
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param integer $code
     * @return Profile|mixed|null
     */
    public function getProfileApplication($code) {
        foreach ($this->getProfilesApplication() as $profile) {
            /** @var Profile $profile */
            if($profile->getCode() == $code)
                return $profile;
        }
        return null;
    }

    /**
     * @param Collection $profiles
     * @return $this
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProfilesApplication() {
        return new ArrayCollection(
            array_unique(array_merge($this->getProfiles()->toArray(), $this->group->getProfiles()->toArray()), SORT_REGULAR)
        );
    }

    /**
     * @param $application_code
     * @return ArrayCollection
     */
    public function getRights($application_code) {
        /* Go through the user's profile and return the one he was connected with last time
            If there's no previous connection, just take the first one of the list
        */
        foreach ($this->getProfilesPrefered() as $profilePrefered) {
            /** @var ProfilePrefered $profilePrefered */
            if ($profilePrefered->getApplication()->getCode() == $application_code) {
                return $profilePrefered->getProfile()->getRights();
            }
        }

        /* If there's no prefered profile atm, send the first profile of the list (from the correct application of course) */
        foreach ($this->getProfilesApplication() as $profile) {
            /** @var Profile $profile */
            if ($profile->getApplication()->getCode() == $application_code) {
                /** @var Profile $profile */
                return $profile->getRights();
            }
        }

        /* If there's no right from this app, return an empty array */
        return new ArrayCollection();
    }

    /**
     * Return the prefered profile by application
     * @param $application_code
     * @return ProfilePrefered
     */
    public function getProfilePrefered($application_code) {
        foreach ($this->getProfilesPrefered() as $profilePrefered) {
            /** @var ProfilePrefered $profilePrefered */
            if ($profilePrefered->getApplication()->getCode() == $application_code) {
                return $profilePrefered;
            }
        }
        return new ProfilePrefered();
    }

    /**
     * Return each profiles prefered
     * @return Collection
     */
    public function getProfilesPrefered()
    {
        return $this->profilesPrefered;
    }

    public function getRoles()
    {
        $rightsRolesToReturn    = new ArrayCollection();
        //First, we get the rights of each application
        foreach ($this->getProfilesApplication() as $profile) {
            /** @var Right $rights */
            $rights = $this->getRights($profile->getApplication()->getCode());
            //For each right, we get the roles
            foreach ($rights as $right) {
                /** @var Right $right */
                foreach ($right->getRoles() as $role) {
                    if (!$rightsRolesToReturn->contains($role)) {
                        $rightsRolesToReturn->add($role);
                    }
                }
            }
        }
        return $rightsRolesToReturn->toArray();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateDate() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Domain
     */
    public function getDomainManaged()
    {
        return $this->domainManaged;
    }

    /**
     * @param Domain $domainManaged
     */
    public function setDomainManaged($domainManaged)
    {
        $this->domainManaged = $domainManaged;
    }

}

