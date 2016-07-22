<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="Front\UserBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="mobilePhone", type="string", length=255, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var int
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;


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
     * Set phone
     *
     * @param integer $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return wordwrap($this->phone, 2, ".", true);
    }

    /**
     * Set mobilePhone
     *
     * @param integer $mobilePhone
     *
     * @return Contact
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return int
     */
    public function getMobilePhone()
    {
        return wordwrap($this->mobilePhone, 2, ".", true);
    }

    /**
     * Set fax
     *
     * @param integer $fax
     *
     * @return Contact
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return int
     */
    public function getFax()
    {
        return $this->fax;
    }
}

