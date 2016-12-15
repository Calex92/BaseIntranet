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
use Front\DomainBundle\Entity\NewsFile;
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
            "Petit texte",
            "Une news déjà dont la date est dépassée",
            "Guide de pose véhicules 2017",
            "Aide au démarrage du nouveau mobile Samsung",
            "News sur la Digitalisation");

        $texts = array("Pellentesque hendrerit, massa at euismod ullamcorper, enim tortor tincidunt sapien, nec convallis nisl mauris eu tellus. Nunc euismod ultrices viverra. Sed in mi ligula, a tincidunt leo. In hac habitasse platea dictumst. Quisque at augue quis tortor euismod tincidunt nec id magna. Vestibulum eu nunc at odi.",
            "On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).",
            "Nulla aliquet convallis tempus. Phasellus sapien turpis, tincidunt a interdum a, sag.",
            "Je suis le corps de texte le plus inutile au monde étant donné que ma date de validité est déjà passée et que je ne serai vu qu'en visualisation du détail d'une news ce qui n'arrivera presque jamais. Après, je peux parler comme ça pendant très longtemps en écrivant tout ce qui me passe par la tête mais ça ne va pas forcément être très intéressant. Tiens, d'ailleurs, je suis déjà plus long que 2 des news précédemment écrites mais je ne vais pas m'arrêter là! Ca serait bien trop facile. C'ets rigolo, j'écris assez vite pour me faire mal au bras mais d'un autre côté, ce n'est pas très utile ... Je vais donc en terminer ici sans avoir rattrapé le dernier corps de texte!",
            "Le nouveau guide de pose véhicules est disponible. Retrouvez tous les kits de pose dans Marketing -> Documents références.",
            "Pour vous aider à démarrer avec le nouveau mobile Samsung, vous pouvez télécharger le manuel en pdf.",
            "Quelques News sur la Digitalisation d'Orexad ! ...");

        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");
        $usersNews = array("1",
            "5",
            "4",
            "5",
            "2",
            "0",
            "1");

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
            "3",
            "3",
            "6",
            "14",
            "3");

        $beginPublication = array ((new \DateTime())->modify('-3 month'),
            (new \DateTime())->modify('-5 days'),
            (new \DateTime())->modify('-7 days'),
            (new \DateTime())->modify('-20 days'),
            (new \DateTime())->modify('-6 days'),
            (new \DateTime())->modify('-2 month'),
            (new \DateTime())->modify('-5 days'),
        );

        $endPublication = array ((new \DateTime())->modify('+1 month'),
            (new \DateTime())->modify('+5 days'),
            (new \DateTime())->modify('+7 days'),
            (new \DateTime())->modify('-5 days'),
            NULL,
            NULL,
            NULL,
        );

        $imageName = array(
            "lorem-ipsum.jpg",
            NULL,
            "Paris.jpg",
            NULL,
            NULL,
            "icon.jpg",
            "news.jpg"
        );

        $externalVideos = array(array(),
            array("https://www.youtube.com/embed/yOW3CaLm1sI", "https://www.youtube.com/embed/77rurM5oRJc", "https://www.youtube.com/embed/usu3wLVTMxA"),
            array("https://www.youtube.com/embed/77rurM5oRJc"),
            array(),
            array(),
            array(),
            array());


        $filesLinked = array(array("newsFile2"),
            array("newsFile0","newsFile1"),
            NULL,
            NULL,
            NULL,
            NULL,
            NULL);

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
            $news->setBeginPublicationDate($beginPublication[$i]);
            $news->setEndPublicationDate($endPublication[$i]);
            $news->setImageName($imageName[$i]);

            foreach ($externalVideos[$i] as $externalVideo) {
                $news->addExternalVideo($externalVideo);
            }

            if ($filesLinked[$i] != NULL) {
                foreach ($filesLinked[$i] as $fileLinked) {
                    /** @var NewsFile $file */
                    $file = $this->getReference($fileLinked);
                    $news->addFile($file);
                }
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