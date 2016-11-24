<?php

namespace Front\DomainBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Table(name="base_domain")
 * @ORM\Entity(repositoryClass="Front\DomainBundle\Repository\DomainRepository")
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
     * @var PersistentCollection(DomainElement)
     *
     * @ORM\OneToMany(targetEntity="Front\DomainBundle\Entity\DomainElement", mappedBy="domain")
     */
    private $domainElements;


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
     * @return Collection
     */
    public function getNews()
    {
         return $this->domainElements->filter(
            function (DomainElement $domainElement) {
                return $domainElement instanceof News;
            }
        );
    }

    /**
     * This is used to get the latest news (1 month ago)
     * @return Collection
     */
    public function getRecentNews() {
        return $this->domainElements->filter(
            function (DomainElement $domainElement) {
                if (new \DateTime("-1 months") > $domainElement->getCreationDate())
                    return false;
                return $domainElement instanceof News;
            }
        );
    }

    /**
     * @return Collection
     */
    public function getDocuments()
    {
        return $this->domainElements->filter(
            function (DomainElement $domainElements) {
                return $domainElements instanceof Document;
            }
        );
    }

    /**
     * This is used to get the latest documents (1 month ago)
     * @return Collection
     */
    public function getRecentDocuments() {
        return $this->domainElements->filter(
            function (DomainElement $domainElements) {
                if (new \DateTime("-1 months") > $domainElements->getCreationDate())
                    return false;
                return $domainElements instanceof Document;
            }
        );
    }
}

