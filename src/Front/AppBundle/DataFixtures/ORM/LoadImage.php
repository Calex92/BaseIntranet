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
        $applications = array ("Administration Isidore 2", "Gestion du portail web");
        $urls = array($applications[0] => "adminisidore 2.png",
                    $applications[1] => "gestion portail web.png");

        $alts = array($applications[0] => "Administration Isidore",
                    $applications[1] => "Gestion portail web");

        for ($i = 0; $i < count($applications) ; $i++) {
            $image = new Image("download/front/applications", $alts[$applications[$i]]);
            $image->setAlt($alts[$applications[$i]]);
            $image->setUrl($urls[$applications[$i]]);

            $this->addReference("image-application".$applications[$i], $image);
            $manager->persist($image);
        }

        $applications = array ("Administration Isidore", "Générateur de signature",
            "Help référenciel",
            "Help ADV",
            "Espaces Grands Comptes",
            "GISS",
            "Omniview",
            "E-learning",
            "Book-Re",
            "Focus",
            "P.F.S Infos",
            "Calendrier livraison",
            "Portail fournisseurs Oradis");

        $urls = array($applications[0] => "adminisidore.png",
            $applications[1] => "logo_signature.gif",
            $applications[2] => "referentiel.png",
            $applications[3] => "HELP-ADV2.png",
            $applications[4] => "espacegrandcompte.png",
            $applications[5] => "giss.jpg",
            $applications[6] => "omniview.jpg",
            $applications[7] => "elearning.png",
            $applications[8] => "bookre.png",
            $applications[9] => "logo_srm.png",
            $applications[10] => "icone pfs info.png",
            $applications[11] => "calendrier livraison.png",
            $applications[12] => "portail_frs.jpg"
            );

        $alts = array($applications[0] => "Administration isidore",
            $applications[1] => "Générateur de signature",
            $applications[2] => "Helpdesk Référentiel",
            $applications[3] => "Help ADV",
            $applications[4] => "Espaces Grands Comptes",
            $applications[5] => "Espace GISS",
            $applications[6] => "Omniview",
            $applications[7] => "E-learning",
            $applications[8] => "Book RE / DR",
            $applications[9] => "Focus",
            $applications[10] => "P.F.S. Infos",
            $applications[11] => "Calendrier livraison",
            $applications[12] => "Portail fournisseur Oradis",
            );

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