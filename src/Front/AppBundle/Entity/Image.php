<?php

namespace Front\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="base_image")
 * @ORM\Entity(repositoryClass="Front\AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var UploadedFile
     * @Assert\File(mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif"})
     */
    private $file;

    private $tempFilename;

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
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if ($this->url !== null) {
            $this->tempFilename = $this->url;

            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @return mixed
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     * @param mixed $tempFilename
     */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if ($this->file === null) {
            return;
        }
        $this->url = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if ($this->file === null) {
            return;
        }
        elseif ($this->tempFilename !== null) {
            $oldFile = $this->getUploadRootDir()."/".$this->getId().".".$this->getTempFilename();

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->getId().".".$this->getUrl()
        );
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    protected function getUploadRootDir() {
        return __DIR__.'/../../../../web/uploads/avatar';
    }

    public function getWebPath() {
        return "uploads/avatar/".$this->getId().".".$this->getUrl();
    }
}

