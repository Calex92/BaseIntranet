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
use Front\AppBundle\Entity\Region;
use Front\AppBundle\Entity\Zone;

class LoadRegion extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $zonesName = array("EST", "OUEST", "CENTRE", "AUTRES");

        $names = array("Bourgogne",
            "Nord Picardie",
            "Normandie",
            "Agence Commerciale 66",
            "Bretagne Est",
            "Ile de France",
            "Pays de Loire",
            "Bretagne Ouest",
            "SAV Ouest",
            "Centre Fimatec",
            "DEFA",
            "Grand Est",
            "Centre Auvergne",
            "Rhone Alpes",
            "Sud",
            "LEPERCQ",
            "SAFIR",
            "CRD",
            "Centre Loire",
            "Sud Ouest",
            "Grand Toulouse",
            "Quincaillerie",
            "BEARING");

        $codes = array($names[0] => "101",
            $names[1] => "102",
            $names[2] => "104",
            $names[3] => "11",
            $names[4] => "202",
            $names[5] => "203",
            $names[6] => "204",
            $names[7] => "205",
            $names[8] => "206",
            $names[9] => "21",
            $names[10] => "23",
            $names[11] => "26",
            $names[12] => "301",
            $names[13] => "302",
            $names[14] => "303",
            $names[15] => "32",
            $names[16] => "37",
            $names[17] => "39",
            $names[18] => "402",
            $names[19] => "403",
            $names[20] => "404",
            $names[21] => "42",
            $names[22] => "55");

        $zones = array($names[0] => $zonesName[0],
            $names[1] => $zonesName[0],
            $names[2] => $zonesName[1],
            $names[3] => $zonesName[3],
            $names[4] => $zonesName[1],
            $names[5] => $zonesName[2],
            $names[6] => $zonesName[1],
            $names[7] => $zonesName[1],
            $names[8] => $zonesName[1],
            $names[9] => $zonesName[2],
            $names[10] => $zonesName[3],
            $names[11] => $zonesName[0],
            $names[12] => $zonesName[2],
            $names[13] => $zonesName[2],
            $names[14] => $zonesName[0],
            $names[15] => $zonesName[3],
            $names[16] => $zonesName[2],
            $names[17] => $zonesName[3],
            $names[18] => $zonesName[2],
            $names[19] => $zonesName[2],
            $names[20] => $zonesName[0],
            $names[21] => $zonesName[1],
            $names[22] => $zonesName[3]);

        for ($i = 0; $i < count($names); $i ++) {
            $region = new Region();
            $region->setName($names[$i]);
            $region->setCode($codes[$names[$i]]);
            $region->setActive(true);
            /**
             * @var Zone $zone
             */
            $zone = $this->getReference("zone".$zones[$names[$i]]);
            $region->setZone($zone);

            $this->setReference("region".$names[$i], $region);

            $manager->persist($region);
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
        return 2;
    }
}