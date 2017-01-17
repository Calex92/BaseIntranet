<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 10/11/2016
 * Time: 14:33
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\ApplicationExternal;

class LoadApplicationExternal extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $applications = array ("Administration Isidore",
            "Générateur de signature",
            "Help référenciel",
            "Help ADV",
            "Espaces Grands Comptes",
            "GISS",
            "Omniview",
            "E-learning",
            "Book-Re",
            "Focus",
            "P.F.S Infos",
            "Calendrier livraison",
            "Portail fournisseurs Oradis",
            "Helpdesk Informatique",
            "Help Bearing");

        $locations = array("application_external_access");

        $destinationRoute = array("",
            "signature/index.php",
            "prp2/index.php",
            "help_adv/index.php",
            "ggc/index.php",
            "espace_giss/",
            "http://isidore/omniview/auth/login",
            "http://192.168.41.16/oregesfi/?key=Uj4_OiezB",
            "histo_book/index.php?page_inc=reporting",
            "/srm",
            "pfs-info/index.php",
            "calendrierLivraison/appointment/index",
            "http://extranet.orexad.com/extranet/litigfrs/auth/login",
            "osi/index.php",
            "/help_plateforme");

        $images = array ("adminisidore.png", "logo_signature.gif",
            "referentiel.png",
            "HElp-ADV2.png",
            "espacegrandcompte.png",
            "GISS.jpg",
            "omniview.jpg",
            "elearning.png",
            "bookre.png",
            "logo_srm.png",
            "icone pfs info.png",
            "calendrier livraison.png",
            "portail_frs.jpg",
            "helpdesk.png",
            "help bearing.png");

        for ($i = 0; $i < count($applications) ; $i++) {
            $application = new ApplicationExternal();
            $application->setName($applications[$i]);
            $application->setLocation($locations[0]);
            $application->setDestinationRoute($destinationRoute[$i]);

            $application->setImageName($images[$i]);

            $application->setUniqueIdentifier($i);

            $this->addReference("application-external".$applications[$i], $application);
            $manager->persist($application);
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