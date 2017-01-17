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
use Front\AppBundle\Entity\Right;

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
            array("Admin", "GISS", "Informatique"));

        $rights = array(
            array("SeeUsers",
                "UpdateUsers",
                "SeeGroups",
                "UpdateGroups",
                "SeeApplications",
                "UpdateApplications",
                "SeeAgencies",
                "UpdateAgencies",
                "SeeRegion",
                "UpdateRegion",
                "SeeZone",
                "UpdateZone",
                "ConnectAsUser"),
            array(
                "Achat",
                "GISS",
                "Informatique"
            )
        );

        $rightsByProfile = array(
            array(
                array(0, 2, 4, 6, 8, 10),
                array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
            ),
            array(
                array(0, 1, 2),
                array(1),
                array(2)
            )
        );

        $applications = array ("Administration Isidore 2", "Gestion du portail web");

        for ($i = 0; $i < count($applications) ; $i++) {
            for ($j = 0; $j < count($profiles[$i]) ; $j++) {
                $profile = new Profile();
                $profile->setName($profiles[$i][$j]);
                /** @var Application $application */
                $application = $this->getReference("application".$applications[$i]);
                $profile->setApplication($application);

                foreach ($rightsByProfile[$i][$j] as $rightElement) {
                    /** @var Right $right */
                    $right = $this->getReference("right".$rights[$i][$rightElement]);
                    $right->setApplication($application);
                    $profile->addRight($right);
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
        return 51;
    }
}