<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 23/12/2016
 * Time: 14:54
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Notification;
use Front\UserBundle\Entity\User;

class LoadNotification extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = array("pfirmin", "gloncke", "acallens", "asergent", "acastelain", "tbarrez");
        $routes = array("domain_manager_news_view", "domain_manager_documents_view", "admin_user_manager_update");
        $params = array(array("id" => 7), array("domain" => "juridique"), array("idUser" => 6));
        $titles = array("Une nouvelles news a été publiée!", "Un document a été ajouté dans le domaine \"Juridique\"", "Un utilisateur a été créé");
        $seen = array(true, false, true);
        $creationDates = array((new \DateTime())->modify('-5 days'),
            (new \DateTime())->modify('-25 days'),
            (new \DateTime())->modify('-47 days')
        );

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($routes); $j++) {
                $notification = new Notification();
                $notification->setTitle($titles[$j]);
                $notification->setRoute($routes[$j]);
                $notification->setParams($params[$j]);
                $notification->setSeen($seen[$j]);
                $notification->setCreationDate($creationDates[$j]);

                /** @var User $user */
                $user = $this->getReference("user".$users[$i]);
                $notification->setUser($user);

                $manager->persist($notification);
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
        return 52;
    }
}