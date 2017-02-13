<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 11/01/2017
 * Time: 13:45
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Group;
use Front\AppBundle\Entity\Profile;
use Front\UserBundle\Entity\User;

class LoadGroup extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users =    array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $userGroup = array(
            array(0, 5, 4),
            array(1, 2)
        );

        $profiles =  array("Viewer", "Creator", "Admin", "News and Document Creator", "Admin référentiel");
        $profileGroup = array(
            array(1, 2, 4),
            array(0, 3)
        );

        $names = array("Administrateurs Isidore", "Non administrateurs");

        for ($i = 0; $i < count($names) ; $i++) {
            $group = new Group();
            $group->setName($names[$i]);

            foreach ($profileGroup[$i] as $profileElement) {
                /** @var Profile $profile */
                $profile = $this->getReference("profile".$profiles[$profileElement]);
                $group->addProfile($profile);
            }

            foreach ($userGroup[$i] as $userElement) {
                /** @var User $user */
                $user = $this->getReference("user".$users[$userElement]);
                $group->addUser($user);
            }

            $manager->persist($group);
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
        return 61;
    }
}