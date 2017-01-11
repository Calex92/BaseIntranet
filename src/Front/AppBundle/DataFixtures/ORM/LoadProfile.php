<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 11/01/2017
 * Time: 12:00
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Application;
use Front\AppBundle\Entity\Profile;
use Front\UserBundle\Entity\User;

class LoadProfile extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $profiles = array(
            array("Viewer", "Creator"),
            array("Admin", "RH", "GISS"));

        $applications = array ("Administration Isidore 2", "Gestion du portail web");
        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $userProfile = array(
            "Viewer" => array(0),
            "Creator" => array(1),
            "Admin" => array(),
            "RH" => array(),
            "GISS" => array()
        );

        for ($i = 0; $i < count($applications) ; $i++) {
            for ($j = 0; $j < count($profiles[$i]) ; $j++) {
                $profile = new Profile();
                $profile->setName($profiles[$i][$j]);
                /** @var Application $application */
                $application = $this->getReference("application".$applications[$i]);
                $profile->setApplication($application);

                foreach ($userProfile[$profiles[$i][$j]] as $userElement) {
                    /** @var User $user */
                    $user = $this->getReference("user".$users[$userElement]);
                    $profile->addUser($user);
                }

                $this->addReference("profile".$profile->getName(), $profile);

                $manager->persist($profile);
            }
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
        return 55;
    }
}