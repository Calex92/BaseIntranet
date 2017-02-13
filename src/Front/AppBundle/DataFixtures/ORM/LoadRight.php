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
                "UpdateZone",
                "ConnectAsUser"),
            array(
                "News creation",
                "Gestion catalogue",
                "Admin"
            ),
            array(
                "CanExport"
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
                "Update zone",
                "Se connecter en tant que"
            ),
            array(
                "Créateur domaine achat",
                "Créateur domaine E-business",
                "Créateur domaine finances",
                "Créateur domaine GISS",
                "Créateur domaine juridique",
                "Créateur domaine logistique",
                "Créateur domaine marketing",
                "Créateur domaine organisation",
                "Créateur domaine perf'co",
                "Créateur domaine qualité",
                "Créateur domaine r.h.",
                "Créateur domaine réseau",
                "Créateur domaine grands comptes",
                "Créateur domaine informatique",
                "Gestion des catalogues",
                "Administrateur"
            ),
            array(
                "Possibilité d'export"
            )
        );

        $roles = array(
            array(array("ROLE_ADMIN_USER_VIEW"),
                array("ROLE_ADMIN_USER_UPDATE"),
                array("ROLE_ADMIN_GROUP_VIEW"),
                array("ROLE_ADMIN_GROUP_UPDATE"),
                array("ROLE_ADMIN_APPLICATION_VIEW"),
                array("ROLE_ADMIN_APPLICATION_UPDATE"),
                array("ROLE_ADMIN_AGENCY_VIEW"),
                array("ROLE_ADMIN_AGENCY_UPDATE"),
                array("ROLE_ADMIN_REGION_VIEW"),
                array("ROLE_ADMIN_REGION_UPDATE"),
                array("ROLE_ADMIN_ZONE_VIEW"),
                array("ROLE_ADMIN_ZONE_UPDATE"),
                array("ROLE_ADMIN_USER_ALLOWED_TO_SWITCH")),
            array(
                array("ROLE_DOMAIN_NEWS_DOCUMENT"),
                array("ROLE_DOMAIN_CATALOG"),
                array("ROLE_DOMAIN_ADMIN")
            ),
            array(
                array("ROLE_REFERENTIEL_EXPORT")
            )
        );

        $codes = array(
            array(
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12
            ),
            array(
                0,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                13,
                14,
                15,
                16
            ),
            array(
                0
            )
        );

        for ($i = 0; $i < count($rights); $i++) {
            for ($j = 0; $j < count($rights[$i]); $j++) {
                $right = new Right();
                $right->setName($rights[$i][$j]);
                $right->setDescription($descriptions[$i][$j]);
                $right->setCode($codes[$i][$j]);
                $right->setRole($roles[$i][$j]);

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