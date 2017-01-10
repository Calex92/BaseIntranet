<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Zone
 *
 * @ORM\Table(name="base_zone")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ZoneRepository")
 * @UniqueEntity(
 *     fields="code",
 *     message="Ce code est déjà utilisé par une autre zone"
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Ce nom est déjà utilisé par une autre zone"
 * )
 */
class Zone
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\Region", mappedBy="zone")
     */
    private $regions;

    /**
     * Zone constructor.
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
     * Set code
     *
     * @param integer $code
     *
     * @return Zone
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
     * @return Zone
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
     * @return Zone
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
     * @return Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param Collection $regions
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;
    }

    /**
     * This function prevent the user to disable the region when there's at least one agency in his list
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function isContentValid(ExecutionContextInterface $context)
    {
        if ($this->getRegions() != NULL) {
            $isStillActiveRegions = false;
            foreach ($this->getRegions() as $region) {
                /** @var Region $region */
                if ($region->getActive()) {
                    $isStillActiveRegions = true;
                    break;
                }
            }

            if ($isStillActiveRegions && !$this->getActive()) {
                // The constraint is violated
                $context
                    ->buildViolation('Impossible de désactiver cette zone, elle contient encore des régions actives.')
                    ->atPath('active') // The attribute that is violated
                    ->addViolation()
                ;
            }
        }
    }
}

