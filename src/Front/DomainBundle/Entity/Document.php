<?php

namespace Front\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Document
 *
 * @ORM\Entity(repositoryClass="Front\DomainBundle\Repository\DocumentRepository")
 * @ORM\Table(name="base_domain_document")
 * @Vich\Uploadable()
 */
class Document extends DomainElement
{
    /**
     * @var  string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @var  File $back_image
     * @Vich\UploadableField(mapping="document_file", fileNameProperty="fileName")
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $fileNameShown;

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFileNameShown()
    {
        return $this->fileNameShown;
    }

    /**
     * @param string $fileNameShown
     */
    public function setFileNameShown($fileNameShown)
    {
        $this->fileNameShown = $fileNameShown;
    }


}

