<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/09/2016
 * Time: 09:25
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Image;

class LoadImage extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $applications = array ("Administration Isidore", "GISS", "Omniview", "E-learning", "Book-Re", "Gestion du portail web");
        $urls = array($applications[0] => "adminisidore.png",
                    $applications[1] => "giss.jpg",
                    $applications[2] => "omniview.jpg",
                    $applications[3] => "elearning.png",
                    $applications[4] => "bookre.png",
                    $applications[5] => "gestion portail web.png");

        $alts = array($applications[0] => "Administration Isidore",
                    $applications[1] => "Espace GISS",
                    $applications[2] => "Omniview",
                    $applications[3] => "E-learning",
                    $applications[4] => "Book RE / DR",
                    $applications[5] => "Gestion portail web");

        for ($i = 0; $i < count($applications) ; $i++) {
            $image = new Image("download/front/applications", $alts[$applications[$i]]);
            $image->setAlt($alts[$applications[$i]]);
            $image->setUrl($urls[$applications[$i]]);

            $this->addReference("image-application".$applications[$i], $image);
            $manager->persist($image);
        }

        $applications = array ("Générateur de signature", "Help référenciel", "Help ADV", "Espaces Grands Comptes");
        $urls = array($applications[0] => "logo_signature.gif",
            $applications[1] => "referentiel.png",
            $applications[2] => "HELP-ADV2.png",
            $applications[3] => "espacegrandcompte.png",);

        $alts = array($applications[0] => "Générateur de signature",
            $applications[1] => "Helpdesk Référentiel",
            $applications[2] => "Help ADV",
            $applications[3] => "Espaces Grands Comptes");

        for ($i = 0; $i < count($applications) ; $i++) {
            $image = new Image("download/front/applications", $alts[$applications[$i]]);
            $image->setAlt($alts[$applications[$i]]);
            $image->setUrl($urls[$applications[$i]]);

            $this->addReference("image-application-external".$applications[$i], $image);
            $manager->persist($image);
        }


        $news = array("Lorem Ipsum",
            "Pourquoi l'utiliser?",
            "Petit texte");
        $urls = array($news[0] => "http://random-ize.com/lorem-ipsum-generators/lorem-ipsum/lorem-ipsum.jpg",
            $news[1] => "http://www.jusderaisin.com/wp-content/uploads/2014/06/Content-is-like-water-1980.jpg",
            $news[2] => "https://www.newton.ac.uk/files/covers/968361.jpg");
        $alts = array($news[0] => "Lorem ipsum",
            $news[1] => "Le contenu, c'est comme l'eau",
            $news[2] => "Couverture");

        for ($i = 0; $i < count($news) ; $i++) {
            $image = new Image("empty", $alts[$news[$i]]);
            $image->setAlt($alts[$news[$i]]);
            $image->setUrl($urls[$news[$i]]);

            $this->addReference("image-news".$news[$i], $image);
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}