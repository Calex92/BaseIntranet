<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 13:50
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Right;

class LoadRight extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
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
                "UpdateZone"),
            array(
                "Achat",
                "GISS",
                "Informatique"
            )
        );

        $descriptions = array(
            array(
                "Voir utilisateurs",
                "Update utilisateurs",
                "Voir groupes",
                "Update groupes",
                "Voir applications",
                "Update applications",
                "Voir agences",
                "Update agences",
                "Voir régions",
                "Update régions",
                "Voir zone",
                "Update zone"
            ),
            array(
                "Créateur domaine achat",
                "Créateur domaine GISS",
                "Créateur domaine informatique"
            )
        );

        for ($i = 0; $i < count($rights); $i++) {
            for ($j = 0; $j < count($rights[$i]); $j++) {
                $right = new Right();
                $right->setName($rights[$i][$j]);
                $right->setDescription($descriptions[$i][$j]);

                $this->addReference("right".$right->getName(), $right);
                $manager->persist($right);
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
        return 50;
    }
}