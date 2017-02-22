<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/09/2016
 * Time: 10:14
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Application;

class LoadApplication extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $applications = array ("Administration Isidore 2", "Gestion du portail web", "Help référentiel 2", "Statistiques");

        $locations = array($applications[0] => "admin_app_homepage",
                    $applications[1] => "domain_manager_index",
                    $applications[2] => "help_referentiel_app_homepage",
                    $applications[3] => "statator_app_homepage");

        $codes = array(1, 2, 3, 4);

        $images = array ("adminisidore 2.png", "gestion portail web.png", "referentiel 2.png", "statator.png");

        for ($i = 0; $i < count($applications) ; $i++) {
            $application = new Application();
            $application->setName($applications[$i]);
            $application->setLocation($locations[$applications[$i]]);
            $application->setCode($codes[$i]);

            $application->setImageName($images[$i]);

            $this->addReference("application".$applications[$i], $application);
            $manager->persist($application);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 40;
    }
}