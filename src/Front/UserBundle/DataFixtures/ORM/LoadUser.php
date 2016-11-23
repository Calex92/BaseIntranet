<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/09/2016
 * Time: 10:35
 */

namespace Front\UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\UserBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = array("pfirmin", "gloncke", "tbarrez", "acallens", "asergent", "acastelain");

        $enableds = array($users[0] => 1,
            $users[1] => 1,
            $users[2] => 1,
            $users[3] => 1,
            $users[4] => 0,
            $users[5] => 1);

        $firstnames = array($users[0] => "Philippe",
            $users[1] => "Grégory",
            $users[2] => "Thomas",
            $users[3] => "Aurélien",
            $users[4] => "Anthony",
            $users[5] => "Alexandre");

        $surnames = array($users[0] => "Firmin",
            $users[1] => "Loncke",
            $users[2] => "Barrez",
            $users[3] => "Callens",
            $users[4] => "Sergent",
            $users[5] => "Castelain");

        $emails = array($users[0] => "pfirmin@orexad.com",
            $users[1] => "gloncke@orexad.com",
            $users[2] => "tbarrez@test.com",
            $users[3] => "acallens@test.com",
            $users[4] => "asergent@orexad.com",
            $users[5] => "alexandre.castelain@orexad.com");

        $passwords = array($users[0] => "popo",
            $users[1] => "popo",
            $users[2] => "popo",
            $users[3] => "popo",
            $users[4] => "popo",
            $users[5] => "popo");

        for ($i = 0; $i < count($users) ; $i++) {
            $user = new User();
            $user->setUsername($users[$i]);
            $user->setSurname($surnames[$users[$i]]);
            $user->setFirstname($firstnames[$users[$i]]);
            $user->setEnabled($enableds[$users[$i]]);
            $user->setEmail($emails[$users[$i]]);
            $user->setPlainPassword($passwords[$users[$i]]);
            $user->setRoles(array('Role_User'));

            $user->setUpdatedAt(new \DateTime());

            if ($this->hasReference("user-contact".$users[$i])) {
                $contact = $this->getReference("user-contact".$users[$i]);
                $user->setContact($contact);
            }

            $this->addReference("user".$users[$i], $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 51;
    }
}