<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\NewsRepository")
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


}

