<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\UserBundle\Entity\User", inversedBy="profiles")
     * @ORM\JoinTable(name="base_profile_user")
     */
    private $users;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Group", inversedBy="profiles")
     * @ORM\JoinTable(name="base_profile_group")
     */
    private $groups;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Application", inversedBy="profile")
     *
     */
    private $application;

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


}

