<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 13/12/2016
 * Time: 17:20
 */

namespace Front\DomainBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\DomainBundle\Entity\NewsFile;

class LoadNewsFile extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $titles = array("Document intéressant",
            "Un autre document intéressant",
            "Imagerie numérique");

        $file_name = array("document1.jpg",
            "document2.PNG",
            "document3.jpg");

        for ($i = 0; $i < count($titles) ; $i ++) {
            $newsFile = new NewsFile();
            $newsFile->setTitle($titles[$i]);
            $newsFile->setFileName($file_name[$i]);

            $this->addReference("newsFile".$i, $newsFile);

            $manager->persist($newsFile);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 50;
    }
}