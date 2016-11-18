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
        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $urls = array($users[0] => "bundles/frontuser/img/basic_avatar.png",
                    $users[1] => "bundles/frontuser/img/basic_avatar.png",
                    $users[2] => "bundles/frontuser/img/basic_avatar.png",
                    $users[3] => "bundles/frontuser/img/basic_avatar.png",
                    $users[4] => "bundles/frontuser/img/basic_avatar.png",
                    $users[5] => "download/front/user/user-profile/Photo officielle.png");

        $alts = array($users[0] => "My profile picture",
                    $users[1] => "My profile picture",
                    $users[2] => "My profile picture",
                    $users[3] => "My profile picture",
                    $users[4] => "My profile picture",
                    $users[5] => "My profile picture");

        for ($i = 0; $i < count($urls) ; $i++) {
            $image = new Image();
            $image->setAlt($alts[$users[$i]]);
            $image->setUrl($urls[$users[$i]]);

            $this->addReference("image-user".$users[$i], $image);
            $manager->persist($image);
        }


        $applications = array ("Administration Isidore", "Grands Comptes", "GISS", "Help référenciel", "Omniview", "E-learning", "Help ADV", "Book-Re");
        $urls = array($applications[0] => "download/front/applications/adminisidore.png",
                    $applications[1] => "download/front/applications/espacegrandcompte.png",
                    $applications[2] => "download/front/applications/giss.jpg",
                    $applications[3] => "download/front/applications/referentiel.png",
                    $applications[4] => "download/front/applications/omniview.jpg",
                    $applications[5] => "download/front/applications/elearning.png",
                    $applications[6] => "download/front/applications/HELP-ADV2.png",
                    $applications[7] => "download/front/applications/bookre.png");

        $alts = array($applications[0] => "Administration Isidore",
                    $applications[1] => "Espaces Grands Comptes",
                    $applications[2] => "Espace GISS",
                    $applications[3] => "Helpdesk Référentiel",
                    $applications[4] => "Omniview",
                    $applications[5] => "E-learning",
                    $applications[6] => "Help ADV",
                    $applications[7] => "Book RE / DR");

        for ($i = 0; $i < count($applications) ; $i++) {
            $image = new Image();
            $image->setAlt($alts[$applications[$i]]);
            $image->setUrl($urls[$applications[$i]]);

            $this->addReference("image-application".$applications[$i], $image);
            $manager->persist($image);
        }

        $applications = array ("Générateur de signature");
        $urls = array($applications[0] => "download/front/applications/logo_signature.gif");

        $alts = array($applications[0] => "Générateur de signature");

        for ($i = 0; $i < count($applications) ; $i++) {
            $image = new Image();
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
            $image = new Image();
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