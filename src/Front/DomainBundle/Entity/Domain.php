<?php

namespace Front\DomainBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="domain")
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
     * @Gedmo\Slug(fields={"label"})
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
     * @var Collection[User]
     *
     * @ORM\OneToMany(targetEntity="Front\UserBundle\Entity\User", mappedBy="domainManaged")
     */
    private $users;

    /**
     * Domain constructor.
     */
    public function __construct()
    {
        $this->active = true;
    }


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
                if (new \DateTime("-1 month") > $domainElement->getBeginPublicationDate()
                    ||  new \DateTime() < $domainElement->getBeginPublicationDate()
                    || ($domainElement->getEndPublicationDate()!= NULL && new \DateTime() > $domainElement->getEndPublicationDate()))
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
            function (DomainElement $domainElement) {
                if (new \DateTime("-1 month") > $domainElement->getBeginPublicationDate()
                    ||  new \DateTime() < $domainElement->getBeginPublicationDate())
                    return false;
                return $domainElement instanceof Document;
            }
        );
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
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function checkUsersDomainActive(ExecutionContextInterface $context) {
        if (!$this->getActive() && count($this->users) > 0) {
            $context
                ->buildViolation('Impossible de désactiver un domaine qui a des utilisateurs gestionnaires') // message
                ->atPath('active')
                ->addViolation();
        }
    }
}

