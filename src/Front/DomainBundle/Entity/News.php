<?php

namespace Front\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Front\AppBundle\Entity\Image;

/**
 * News
 * @ORM\Entity(repositoryClass="Front\DomainBundle\Repository\NewsRepository")
 * @ORM\Table(name="base_domain_news")
 */
class News extends DomainElement
{
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var  Image
     *
     * @ORM\OneToOne(targetEntity="Front\AppBundle\Entity\Image", cascade={"remove"})
     */
    private $image;

    /**
     * @var array
     *
     * @ORM\Column(name="external_video", type="array")
     */
    private $externalVideo;

    /**
     * News constructor.
     */
    public function __construct()
    {
        $this->externalVideo = array();
    }


    /**
     * Set text
     *
     * @param string $text
     *
     * @return News
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return array
     */
    public function getExternalVideo()
    {
        return $this->externalVideo;
    }

    /**
     * @param array $externalVideo
     */
    public function setExternalVideo($externalVideo)
    {
        $this->externalVideo = $externalVideo;
    }

    /**
     * @param string $externalVideo
     */
    public function addExternalVideo($externalVideo) {
        $this->externalVideo[] = $externalVideo;
    }
}

