<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table(name="base_application")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ApplicationRepository")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"Application" = "Application", "ApplicationExternal" = "ApplicationExternal"})
 */
class Application
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;


    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Front\AppBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\Profile", mappedBy="application")
     */
    private $profiles;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\Right", mappedBy="application")
     */
    private $rights;

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
     * @return Application
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
     * @return image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function isExternal() {
        return false;
    }

    /**
     * @return ArrayCollection
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

    public function __toString() {
        return $this->id."";
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
            $right->setApplication($this);
            $this->rights->add($right);
        }
        return $this;
    }
}

