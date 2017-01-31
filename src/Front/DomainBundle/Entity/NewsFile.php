<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 29/11/2016
 * Time: 17:47
 */

namespace Front\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Table(name="domain_news_file")
 * @ORM\Entity(repositoryClass="Front\DomainBundle\Repository\NewsFileRepository")
 * @Vich\Uploadable()
 */
class NewsFile
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
     * @var  string
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var  string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $fileName;

    /**
     * @var  File $back_image
     * @Vich\UploadableField(mapping="news_file", fileNameProperty="fileName")
     */
    protected $file;

    /**
     * @var News
     * @ORM\ManyToOne(targetEntity="Front\DomainBundle\Entity\News", inversedBy="files", cascade={"remove"})
     */
    protected $news;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $file_name
     */
    public function setFileName($file_name)
    {
        $this->fileName = $file_name;
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
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     * @return News
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param News $news
     */
    public function setNews($news)
    {
        $this->news = $news;
    }


}
