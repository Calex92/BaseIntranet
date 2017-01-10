<?php

namespace Front\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Region
 *
 * @ORM\Table(name="base_region")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\RegionRepository")
 * @UniqueEntity(
 *     fields={"code"},
 *     message="Ce code est déjà utilisé par une autre région"
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Ce nom est déjà utilisé par une autre région"
 * )
 */
class Region
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
     * @var Zone
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Zone", inversedBy="regions")
     */
    private $zone;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\Agency", mappedBy="region")
     */
    private $agencies;


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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param Zone $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }

    /**
     * @return Collection
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * @param Collection $agencies
     */
    public function setAgencies($agencies)
    {
        $this->agencies = $agencies;
    }

    /**
     * This function prevent the user to disable the region when there's at least one agency in his list
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function isContentValid(ExecutionContextInterface $context)
    {
        if ($this->getAgencies() != NULL) {
            $isStillActiveAgencies = false;
            foreach ($this->getAgencies() as $agency) {
                /** @var Agency $agency */
                if ($agency->getActive()) {
                    $isStillActiveAgencies = true;
                    break;
                }
            }

            if ($isStillActiveAgencies && !$this->getActive()) {
                // The constraint is violated
                $context
                    ->buildViolation('Impossible de désactiver cette region, elle contient encore des agences actives.')// message
                    ->atPath('active')// The attribute that is violated
                    ->addViolation()
                ;
            }
        }
    }
}

