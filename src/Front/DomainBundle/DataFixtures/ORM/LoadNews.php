<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 02/11/2016
 * Time: 15:11
 */

namespace Front\DomainBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Front\DomainBundle\Entity\Domain;
use Front\DomainBundle\Entity\News;
use Front\UserBundle\Entity\User;

class LoadNews extends AbstractFixture implements OrderedFixtureInterface
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

        $texts = array("Pellentesque hendrerit, massa at euismod ullamcorper, enim tortor tincidunt sapien, nec convallis nisl mauris eu tellus. Nunc euismod ultrices viverra. Sed in mi ligula, a tincidunt leo. In hac habitasse platea dictumst. Quisque at augue quis tortor euismod tincidunt nec id magna. Vestibulum eu nunc at odi.",
            "On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).",
            "Nulla aliquet convallis tempus. Phasellus sapien turpis, tincidunt a interdum a, sag.");

        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $usersNews = array("1",
            "5",
            "4");

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
        $labelsNews = array("0",
            "9",
            "3");

        $externalVideos = array(array(),
            array("https://www.youtube.com/embed/yOW3CaLm1sI", "https://www.youtube.com/embed/77rurM5oRJc", "https://www.youtube.com/embed/usu3wLVTMxA"),
            array("https://www.youtube.com/embed/77rurM5oRJc"));


        for ($i = 0; $i < count($titles); $i++) {
            $news = new News();
            $news->setTitle($titles[$i]);
            $news->setText($texts[$i]);
            /** @var User $user */
            $user = $this->getReference("user".$users[$usersNews[$i]]);
            $news->setCreator($user);
            /** @var Domain $domain */
            $domain = $this->getReference("news-domain".$labelsDomain[$labelsNews[$i]]);
            $news->setDomain($domain);
           // $news->setImage($image);
            $news->setCreationDate(new \DateTime());
            $news->setBeginPublicationDate(new \DateTime());
            $news->setEndPublicationDate((new \DateTime())->add(new \DateInterval('P10D')));

            foreach ($externalVideos[$i] as $externalVideo) {
                $news->addExternalVideo($externalVideo);
            }

            $manager->persist($news);
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
        return 60;
    }
}