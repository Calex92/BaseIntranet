<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * ProfilePrefered
 *
 * @ORM\Table(name="base_profile_prefered")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ProfilePreferedRepository")
 */
class ProfilePrefered
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Front\UserBundle\Entity\User", inversedBy="profilesPrefered")
     */
    private $user;

    /**
     * @var Profile
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Profile")
     */
    private $profile;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Application")
     */
    private $application;

    /**
     * ProfilePrefered constructor.
     */
    public function __construct()
    {
        $this->profile = new Profile();
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     * @return $this
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
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
     * @return $this
     */
    public function setApplication($application)
    {
        $this->application = $application;
        return $this;
    }
}

