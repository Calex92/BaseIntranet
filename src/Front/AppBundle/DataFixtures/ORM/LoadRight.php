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
                "Gestionnaire d'un domaine",
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

        for ($i = 0; $i < count($rights); $i++) {
            for ($j = 0; $j < count($rights[$i]); $j++) {
                $right = new Right();
                $right->setName($rights[$i][$j]);
                $right->setDescription($descriptions[$i][$j]);
                $right->setCode(intval($i.$j));
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