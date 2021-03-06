<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/11/2016
 * Time: 14:25
 */

namespace Front\DomainBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\Table(name="domain_element")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"news" = "News", "document" = "Document"})
 */
abstract class DomainElement
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Front\UserBundle\Entity\User")
     */
    private $creator;

    /**
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="Front\DomainBundle\Entity\Domain", inversedBy="domainElements")
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="date")
     */
    private $creationDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="begin_publication_date", type="date")
     */
    private $beginPublicationDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="end_publication_date", type="date", nullable=true)
     */
    private $endPublicationDate;

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
     * Set title
     *
     * @param string $title
     *
     * @return DomainElement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return DomainElement
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }


    /**
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return \DateTime
     */
    public function getBeginPublicationDate()
    {
        return $this->beginPublicationDate;
    }

    /**
     * @param \DateTime $beginPublicationDate
     */
    public function setBeginPublicationDate($beginPublicationDate)
    {
        $this->beginPublicationDate = $beginPublicationDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndPublicationDate()
    {
        return $this->endPublicationDate;
    }

    /**
     * @param \DateTime $endPublicationDate
     */
    public function setEndPublicationDate($endPublicationDate)
    {
        $this->endPublicationDate = $endPublicationDate;
    }
}
