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
use Front\DomainBundle\Entity\Catalog;
use Front\UserBundle\Entity\User;

class LoadCatalog extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $titles = array("Bons plans 25 + EPI automne hiver 2016/17",
            "L'expert usinage 2017 + Le tarif l'expert usinage",
            "La sélection transmission 2015",
            "Les bons plans 24",
            "Les arrivages Orexad N°2");

        $fileNames = array("Pack_Lancement_BP25_AH_16-17.zip",
            "pack_usinage_2017_integres.zip",
            "pack_catalogue_transmission_oct-dec_2015.zip",
            "pack_catalogue_transmission_oct-dec_2015.zip",
            "pack_catalogue_transmission_oct-dec_2015.zip");

        $fileNameShown = array("Bons plans 25",
            "Expert usinage",
            "Sélection transmission 2015",
            "Bons plans 24",
            "Arrivages Orexad 2");

        $imageName = array("bp25_epi.jpg",
            "vignette_usinage_tarif_integres.jpg",
            "img-transmission_100.png",
            "bp24.jpg",
            "pack2.png");

        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $usersDocument = array("0",
            "3",
            "5",
            "0",
            "1",
            "5");

        $isLeft = array(false,
            false,
            true,
            true,
            false);

        $beginPublication = array ((new \DateTime())->modify('-1 day'),
            (new \DateTime())->modify('-5 days'),
            (new \DateTime())->modify('-7 days'),
            (new \DateTime())->modify('-3 month'),
            (new \DateTime())->modify('-25 days'),
        );


        for ($i = 0; $i < count($titles); $i++) {
            $catalog = new Catalog();
            $catalog->setTitle($titles[$i]);
            /** @var User $user */
            $user = $this->getReference("user".$users[$usersDocument[$i]]);
            $catalog->setCreator($user);
            $catalog->setFileName($fileNames[$i]);
            $catalog->setFileNameShown($fileNameShown[$i]);
            $catalog->setImageName($imageName[$i]);
            $catalog->setBeginPublicationDate($beginPublication[$i]);
            $catalog->setPositionLeft($isLeft[$i]);
            $catalog->setVisible(true);

            $catalog->setCreationDate(new \DateTime());
            $catalog->setUpdatedAt(new \DateTime());

            $manager->persist($catalog);
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
        return 53;
    }
}