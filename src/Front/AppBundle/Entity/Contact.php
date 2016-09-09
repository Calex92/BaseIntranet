<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="Front\UserBundle\Repository\ContactRepository")
 */
class Contact
{
    const SEPARATOR = " ";


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
     * @Assert\Regex(pattern="/^\d{8,14}$/", message="Le numéro ne doit contenir QUE des chiffres et faire entre 8 et 14 caractères")
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="mobilePhone", type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/^\d{8,14}$/", message="Le numéro ne doit contenir QUE des chiffres et faire entre 8 et 14 caractères")
     */
    private $mobilePhone;

    /**
     * @var int
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/^\d{8,14}$/", message="Le numéro ne doit contenir QUE des chiffres et faire entre 8 et 14 caractères")
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
        $this->phone = $this->removeBadCharPhone($phone);

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return wordwrap($this->phone, 2, self::SEPARATOR, true);
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
        $this->mobilePhone = $this->removeBadCharPhone($mobilePhone);

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return int
     */
    public function getMobilePhone()
    {
        return wordwrap($this->mobilePhone, 2, self::SEPARATOR, true);
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
        $this->fax = $this->removeBadCharPhone($fax);

        return $this;
    }

    /**
     * Get fax
     *
     * @return int
     */
    public function getFax()
    {
        return wordwrap($this->fax, 2, self::SEPARATOR, true);
    }

    private function removeBadCharPhone($phone) {
        return str_replace(str_split('\\/:*?"<>=|+- '), '', $phone);
    }
}

