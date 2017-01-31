<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * ApplicationConnectionStatistics
 *
 * @ORM\Table(name="base_application_connection")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ApplicationConnectionStatisticsRepository")
 */
class ApplicationConnectionStatistics
{
    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Front\AppBundle\Entity\Application")
     */
    private $application;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Front\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=255)
     */
    private $browser;

    /**
     * @var string
     *
     * @ORM\Column(name="operatigSystem", type="string", length=255)
     */
    private $operatigSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="profileName", type="string", length=255)
     */
    private $profileName;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAdress", type="string", length=255)
     */
    private $ipAdress;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ApplicationConnectionStatistics
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set browser
     *
     * @param string $browser
     *
     * @return ApplicationConnectionStatistics
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set profileName
     *
     * @param string $profileName
     *
     * @return ApplicationConnectionStatistics
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;

        return $this;
    }

    /**
     * Get profileName
     *
     * @return string
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * Set ipAdress
     *
     * @param string $ipAdress
     *
     * @return ApplicationConnectionStatistics
     */
    public function setIpAdress($ipAdress)
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    /**
     * Get ipAdress
     *
     * @return string
     */
    public function getIpAdress()
    {
        return $this->ipAdress;
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
     * @return $this
     */
    public function setApplication($application)
    {
        $this->application = $application;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperatigSystem()
    {
        return $this->operatigSystem;
    }

    /**
     * @param string $operatigSystem
     * @return $this
     */
    public function setOperatigSystem($operatigSystem)
    {
        $this->operatigSystem = $operatigSystem;
        return $this;
    }


}

