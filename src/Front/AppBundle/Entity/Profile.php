<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * Profile
 *
 * @ORM\Table(name="base_profile")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ProfileRepository")
 */
class Profile
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\UserBundle\Entity\User", mappedBy="profiles", cascade={"persist"})
     *
     */
    private $users;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Group", mappedBy="profiles", cascade={"persist"})
     */
    private $groups;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Application", inversedBy="profiles", cascade={"persist"})
     *
     */
    private $application;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Right", inversedBy="profiles", cascade={"persist"})
     * @ORM\JoinTable(name="base_profile_right")
     *
     */
    private $rights;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_last_connection_profile", type="boolean")
     */
    private $isLastConnectionProfile;

    /**
     * Profile constructor.
     */
    public function __construct()
    {
        $this->users    = new ArrayCollection();
        $this->groups   = new ArrayCollection();
        $this->rights   = new ArrayCollection();
        $this->isLastConnectionProfile = false;
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
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param Collection $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function addUser(User $user) {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }
        return $this;
    }

    public function addGroup(Group $group) {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param ArrayCollection $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }

    public function addRight(Right $right) {
        if (!$this->rights->contains($right)) {
            $right->addProfile($this);
            $this->rights->add($right);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isLastConnectionProfile()
    {
        return $this->isLastConnectionProfile;
    }

    /**
     * @param bool $isLastConnectionProfile
     */
    public function setIsLastConnectionProfile($isLastConnectionProfile)
    {
        $this->isLastConnectionProfile = $isLastConnectionProfile;
    }
}

