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
use Front\AppBundle\Entity\Agency;

class LoadAgency extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $agencies= array("PLOISY", "BEARING EXPRESS", "NEGOCE DUNKERQUE", "TRNOVEC NAD VAHOM", "WAREGEM", "Dunkerque", "Orexad Albaut Rouen Plateforme");

        $codes = array($agencies[0] => 2,
                    $agencies[1] => 112,
                    $agencies[2] => 116,
                    $agencies[3] => 164,
                    $agencies[4] => 166,
                    $agencies[5] => 191,
                    $agencies[6] => 244);

        $actives = array($agencies[0] => 1,
                    $agencies[1] => 1,
                    $agencies[2] => 1,
                    $agencies[3] => 0,
                    $agencies[4] => 1,
                    $agencies[5] => 1,
                    $agencies[6] => 1);

        $creationDates = array($agencies[0] => new \DateTime("06-06-2016"),
            $agencies[1] => new \DateTime("06-06-2015"),
            $agencies[2] => new \DateTime("25-05-2016"),
            $agencies[3] => new \DateTime("08-06-2015"),
            $agencies[4] => new \DateTime("06-09-2012"),
            $agencies[5] => new \DateTime("24-07-2010"),
            $agencies[6] => new \DateTime("07-08-2009"));

        $adresses = array($agencies[0] => "Le Bras de Fer Z.A.C du Plateau",
            $agencies[1] => "Rue Andre Joseph",
            $agencies[2] => "1294, Rue Achille Peres",
            $agencies[3] => "",
            $agencies[4] => "",
            $agencies[5] => "",
            $agencies[6] => "26, Rue de la Grande Epine");

        $emails = array($agencies[0] => "advsoisson@orexad.com",
            $agencies[1] => "bearing.express@orexad.com",
            $agencies[2] => "negoce.mtcmecanord@orexad.com",
            $agencies[3] => "",
            $agencies[4] => "",
            $agencies[5] => "",
            $agencies[6] => "contact@albaut-villette.fr");


        for ($i = 0; $i < count($agencies) ; $i++) {
            $agency = new Agency();
            $agency->setActive($actives[$agencies[$i]]);
            $agency->setAdress($adresses[$agencies[$i]]);
            $agency->setCode($codes[$agencies[$i]]);
            $agency->setName($agencies[$i]);
            $agency->setCreationDate($creationDates[$agencies[$i]]);
            $agency->setEmail($emails[$agencies[$i]]);


            $this->addReference("agency".$agencies[$i], $agency);
            $manager->persist($agency);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}