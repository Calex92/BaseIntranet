<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Front\UserBundle\Entity\User;

/**
 * Notification
 *
 * @ORM\Table(name="base_notification")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255)
     */
    private $route;

    /**
     * @var array
     *
     * @ORM\Column(name="params", type="array", nullable=true)
     */
    private $params;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @ORM\ManyToOne(targetEntity="Front\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, unique=false)
     */
    private $user;

    /**
     * Notification constructor.
     * @param string $title
     * @param string $route
     * @param array $params
     * @param $user
     */
    public function __construct($title, $route, $user, array $params = array())
    {
        $this->title = $title;
        $this->route = $route;
        $this->params = $params;
        $this->creationDate = new \DateTime();
        $this->seen = false;
        $this->user = $user;
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
     * Set title
     *
     * @param string $title
     *
     * @return Notification
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
     * Set route
     *
     * @param string $route
     *
     * @return Notification
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set params
     *
     * @param array $params
     *
     * @return Notification
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        if ($this->params === NULL)
            return array();
        return $this->params;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Notification
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
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return bool
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}

