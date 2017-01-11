<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="base_group")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\GroupRepository")
 */
class Group
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
     * @ORM\ManyToMany(targetEntity="Front\UserBundle\Entity\User", inversedBy="groups")
     * @ORM\JoinTable(name="base_group_user")
     */
    private $users;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Profile", mappedBy="groups")
     */
    private $profiles;

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
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param Collection $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }


}

