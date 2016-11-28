<?php

namespace Front\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 * @ORM\Entity(repositoryClass="Front\DomainBundle\Repository\NewsRepository")
 * @ORM\Table(name="base_domain_news")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
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
     * @Vich\UploadableField(mapping="news_image", fileNameProperty="imageName")
     *
     * @var File
     * @Assert\File(mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var array
     *
     * @ORM\Column(name="external_video", type="array")
     */
    private $externalVideo;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

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

    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return News
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }


    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setDate()
    {
        if (gettype($this->getBeginPublicationDate()) == "string") {
            $this->setBeginPublicationDate(\DateTime::createFromFormat("d/m/Y", $this->getBeginPublicationDate()));
        }
        if (gettype($this->getEndPublicationDate()) == "string") {
            $this->setEndPublicationDate(\DateTime::createFromFormat("d/m/Y", $this->getEndPublicationDate()));
        }

        $this->updatedAt = new \DateTime('now');
    }

}

