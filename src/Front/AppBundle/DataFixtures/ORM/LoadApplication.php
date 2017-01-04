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
use Front\AppBundle\Entity\Image;

class LoadApplication extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $applications = array ("Administration Isidore", "GISS", "Omniview", "E-learning", "Book-Re", "Gestion du portail web");

        $locations = array($applications[0] => "admin_user_manager_homepage",
                    $applications[1] => "admin_user_manager_homepage",
                    $applications[2] => "admin_user_manager_homepage",
                    $applications[3] => "admin_user_manager_homepage",
                    $applications[4] => "admin_user_manager_homepage",
                    $applications[5] => "domain_manager_index");

        for ($i = 0; $i < count($applications) ; $i++) {
            $application = new Application();
            $application->setName($applications[$i]);
            $application->setLocation($locations[$applications[$i]]);
            /** @var Image $image */
            $image = $this->getReference("image-application".$applications[$i]);
            $application->setImage($image);

            $this->addReference("application".$applications[$i], $application);
            $manager->persist($application);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 50;
    }
}