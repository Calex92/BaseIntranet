<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/11/2016
 * Time: 15:12
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Document;
use Front\AppBundle\Entity\Domain;
use Front\UserBundle\Entity\User;

class LoadDocument extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $titles = array("Lorem Ipsum",
            "Pourquoi l'utiliser?",
            "Petit texte");

        $types = array("application PDF",
            "application msw",
            "application vnd");

        $fileNames = array("Fichier Excel",
            "Fichier Msw",
            "Fichier Vnd");

        $filePath = array("bundles/frontapp/documents/5760.doc",
            "bundles/frontapp/documents/7692.xlsx",
            "bundles/frontapp/documents/5760.doc");

        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $usersDocument = array("0",
            "3",
            "5");

        $labelsDomain = array("Achat",
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
        $labelsDocument = array("3",
            "4",
            "7");


        for ($i = 0; $i < count($titles); $i++) {
            $document = new Document();
            $document->setTitle($titles[$i]);
            /** @var User $user */
            $user = $this->getReference("user".$users[$usersDocument[$i]]);
            $document->setCreator($user);
            /** @var Domain $domain */
            $domain = $this->getReference("news-domain".$labelsDomain[$labelsDocument[$i]]);
            $document->setDomain($domain);
            $document->setType($types[$i]);
            $document->setFileName($fileNames[$i]);
            $document->setFilePath($filePath[$i]);

            $document->setCreationDate(new \DateTime());

            $manager->persist($document);
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