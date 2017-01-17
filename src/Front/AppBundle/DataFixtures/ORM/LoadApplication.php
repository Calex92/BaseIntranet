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
        $applications = array ("Administration Isidore 2", "Gestion du portail web");

        $locations = array($applications[0] => "admin_app_homepage",
                    $applications[1] => "domain_manager_index");

        $images = array ("adminisidore 2.png", "gestion portail web.png");

        for ($i = 0; $i < count($applications) ; $i++) {
            $application = new Application();
            $application->setName($applications[$i]);
            $application->setLocation($locations[$applications[$i]]);
            $application->setCode($i);

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