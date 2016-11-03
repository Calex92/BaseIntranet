<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * newsDomain
 *
 * @ORM\Table(name="base_news_domain")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\DomainRepository")
 */
class Domain
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="labelSimplified", type="string", length=255)
     */
    private $labelSimplified;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var array(News)
     *
     * @ORM\OneToMany(targetEntity="Front\AppBundle\Entity\News", mappedBy="domain")
     */
    private $news;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return domain
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return domain
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getLabelSimplified()
    {
        return $this->labelSimplified;
    }

    /**
     * @param string $labelSimplified
     */
    public function setLabelSimplified($labelSimplified)
    {
        $this->labelSimplified = $labelSimplified;
    }

    /**
     * @return array
     */
    public function getNews()
    {
        return $this->news;
    }
}

