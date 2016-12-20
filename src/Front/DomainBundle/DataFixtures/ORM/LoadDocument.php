<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/11/2016
 * Time: 15:12
 */

namespace Front\DomainBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\DomainBundle\Entity\Document;
use Front\DomainBundle\Entity\Domain;
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
        $titles = array("Procédure Réseau",
            "Procédure de gestion des baies informatique en agence",
            "Charte informatique",
            "Autre fichier important",
            "Organigramme service Juridique dec. 2016",
            "Masque prez OREXAD 2015");

        $fileNames = array("5859100415b07_depositphotos_98601436-Cloud-hosting-icons-set",
            "7692.xlsx",
            "5760.doc",
            "5760.doc",
            "5760.doc",
            "5760.doc");

        $fileNameShown = array("Procédure Réseau",
            "Procédure gestion baies informatique",
            "Charte informatique",
            "Document important!",
            "Organigramme service Juridique",
            "Masque OREXAD");

        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $usersDocument = array("0",
            "3",
            "5",
            "0",
            "1",
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
            "7",
            "5",
            "4",
            "8");

        $beginPublication = array ((new \DateTime())->modify('-3 month'),
            (new \DateTime())->modify('-5 days'),
            (new \DateTime())->modify('-7 days'),
            (new \DateTime())->modify('-2 month'),
            (new \DateTime())->modify('-2 days'),
            (new \DateTime())->modify('-11 month'),
        );


        for ($i = 0; $i < count($titles); $i++) {
            $document = new Document();
            $document->setTitle($titles[$i]);
            /** @var User $user */
            $user = $this->getReference("user".$users[$usersDocument[$i]]);
            $document->setCreator($user);
            /** @var Domain $domain */
            $domain = $this->getReference("news-domain".$labelsDomain[$labelsDocument[$i]]);
            $document->setDomain($domain);
            $document->setFileName($fileNames[$i]);
            $document->setFileNameShown($fileNameShown[$i]);
            $document->setBeginPublicationDate($beginPublication[$i]);

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