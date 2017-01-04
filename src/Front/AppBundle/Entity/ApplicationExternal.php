<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/11/2016
 * Time: 14:24
 */

namespace Front\AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationExternal
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ApplicationExternalRepository")
 */
class ApplicationExternal extends Application
{

    /**
     * @var string
     *
     * @ORM\Column(name="destination_route", type="string", length=255, unique=true)
     */
    private $destinationRoute;

    /**
     * @var integer
     *
     * @ORM\Column(name="unique_identifier", type="integer")
     */
    private $uniqueIdentifier;

    /**
     * @return string
     */
    public function getDestinationRoute()
    {
        return $this->destinationRoute;
    }

    /**
     * @param string $destinationRoute
     */
    public function setDestinationRoute($destinationRoute)
    {
        $this->destinationRoute = $destinationRoute;
    }


    public function isExternal()
    {
        return true;
    }

    /**
     * @return int
     */
    public function getUniqueIdentifier()
    {
        return $this->uniqueIdentifier;
    }

    /**
     * @param int $uniqueIdentifier
     */
    public function setUniqueIdentifier($uniqueIdentifier)
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
    }
}