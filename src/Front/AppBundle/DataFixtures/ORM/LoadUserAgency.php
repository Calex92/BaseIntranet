<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/01/2017
 * Time: 11:30
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Agency;
use Front\AppBundle\Entity\UserAgency;
use Front\UserBundle\Entity\User;

class LoadUserAgency extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $agencies= array("Ploisy", "Bearing Express", "Negoce Dunkerque", "Trnovec Nad Vahom", "Waregem", "Dunkerque", "Orexad Albaut Rouen Plateforme");

        $linkAccess = array(
            array(1, 1, 0, 0, 0, 0, 1),
            array(0, 1, 0, 0, 0, 0, 0),
            array(0, 0, 1, 0, 0, 0, 0),
            array(0, 0, 0, 0, 0, 0, 0),
            array(0, 1, 1, 0, 1, 0, 0),
            array(1, 1, 0, 0, 1, 0, 0),
        );

        $linkPrincipal = array(
            array(true, false, false, false, false, false, false),
            array(false, true, false, false, false, false, false),
            array(false, false, true, false, false, false, false),
            array(false, false, false, false, false, false, false),
            array(false, false, true, false, false, false, false),
            array(true, false, false, false, false, false, false),
        );

        for ($i = 0 ; $i < count($users) ; $i ++) {
            for ($j = 0; $j < count($agencies) ; $j ++) {
                if (!$linkAccess[$i][$j]) {
                    continue;
                }
                /** @var User $user */
                $user = $this->getReference("user".$users[$i]);
                /** @var Agency $agency */
                $agency = $this->getReference("agency".$agencies[$j]);
                $userAgency = new UserAgency($user, $agency, $linkPrincipal[$i][$j]);

                $manager->persist($userAgency);
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
        return 60;
    }
}