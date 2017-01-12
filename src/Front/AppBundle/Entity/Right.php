<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rights
 *
 * @ORM\Table(name="base_right")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\RightRepository")
 */
class Right
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Application", inversedBy="rights")
     */
    private $application;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Front\AppBundle\Entity\Profile", inversedBy="rights")
     * @ORM\JoinTable(name="base_right_profile")
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
     * Set name
     *
     * @param string $name
     *
     * @return Right
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
     * Set description
     *
     * @param string $description
     *
     * @return Right
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return ArrayCollection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param ArrayCollection $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }

    public function addProfile(Profile $profile) {
        if (!$this->profiles->contains($profile)) {
            $profile->addRight($this);
            $this->profiles->add($profile);
        }
        return $this;
    }
}

