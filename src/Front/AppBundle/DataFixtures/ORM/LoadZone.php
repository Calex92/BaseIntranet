<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/01/2017
 * Time: 14:46
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Zone;

class LoadZone extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array("EST", "OUEST", "CENTRE", "AUTRES");
        $codes = array($names[0] => "1",
            $names[1] => "2",
            $names[2] => "3",
            $names[3] => "4");

        for ($i = 0; $i < count($names); $i ++) {
            $zone = new Zone();
            $zone->setName($names[$i]);
            $zone->setCode($codes[$names[$i]]);
            $zone->setActive(true);

            $this->addReference("zone".$names[$i], $zone);
            $manager->persist($zone);

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
        return 1;
    }
}