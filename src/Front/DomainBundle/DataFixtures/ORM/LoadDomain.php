<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 02/11/2016
 * Time: 15:00
 */

namespace Front\DomainBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\DomainBundle\Entity\Domain;

class LoadDomain extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $labels = array("Achat",
            "E-business",
            "Finances",
            "GISS",
            "Juridique",
            "Logistique",
            "Marketing",
            "Métiers",
            "Organisation",
            "Perf'Co",
            "Qualité",
            "R.H.",
            "Réseau",
            "Grands Comptes",
            "Informatique");

        $labelsSimplified = array("achat",
            "ebusiness",
            "finances",
            "giss",
            "juridique",
            "logistique",
            "marketing",
            "metiers",
            "organisation",
            "perfco",
            "qualite",
            "rh",
            "reseau",
            "grandscomptes",
            "informatique");

        $actives = array(1,
            1,
            1,
            1,
            1,
            1,
            1,
            0,
            1,
            1,
            1,
            1,
            1,
            1,
            1);

        $roles = array(
            "ROLE_DOMAIN_ACHAT",
            "ROLE_DOMAIN_EBUISINESS",
            "ROLE_DOMAIN_FINANCES",
            "ROLE_DOMAIN_GISS",
            "ROLE_DOMAIN_JURIDIQUE",
            "ROLE_DOMAIN_LOGISTIQUE",
            "ROLE_DOMAIN_MARKETING",
            "ROLE_DOMAIN_METIER",
            "ROLE_DOMAIN_ORGANISATION",
            "ROLE_DOMAIN_PERFCO",
            "ROLE_DOMAIN_QUALITE",
            "ROLE_DOMAIN_RH",
            "ROLE_DOMAIN_RESEAU",
            "ROLE_DOMAIN_GRANDSCOMPTES",
            "ROLE_DOMAIN_INFORMATIQUE"
        );


        for ($i = 0; $i < count($labels) ; $i++) {
            $newsDomain = new Domain();
            $newsDomain->setLabel($labels[$i]);
            $newsDomain->setLabelSimplified($labelsSimplified[$i]);
            $newsDomain->setActive($actives[$i]);
            $newsDomain->setRole($roles[$i]);

            $this->addReference("news-domain".$labels[$i], $newsDomain);
            $manager->persist($newsDomain);
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
        return 20;
    }
}