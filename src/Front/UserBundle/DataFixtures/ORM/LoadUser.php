<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/09/2016
 * Time: 10:35
 */

namespace Front\UserBundle\DataFixtures\ORM;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Profile;
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

        $profilesUser = array($users[0] => array("Viewer"),
            $users[1] => array("Creator"),
            $users[2] => array(),
            $users[3] => array(),
            $users[4] => array(),
            $users[5] => array("News and Document Creator", "Viewer"));

        for ($i = 0; $i < count($users); $i++) {
            $user = new User();
            $user->setUsername($users[$i]);
            $user->setSurname($surnames[$users[$i]]);
            $user->setFirstname($firstnames[$users[$i]]);
            $user->setEnabled($enableds[$users[$i]]);
            $user->setEmail($emails[$users[$i]]);
            $user->setPlainPassword($passwords[$users[$i]]);
            $user->setRoles(array('Role_User'));
            $user->setLastPasswordChange(new \DateTime());

            $user->setUpdatedAt(new \DateTime());

            if ($this->hasReference("user-contact" . $users[$i])) {
                $contact = $this->getReference("user-contact" . $users[$i]);
                $user->setContact($contact);
            }

            foreach ($profilesUser[$users[$i]] as $profile) {
                /** @var Profile $profileDb */
                $profileDb = $this->getReference("profile" . $profile);
                if ($user->getProfiles()->count() > 0) {
                    $user->setProfiles(new ArrayCollection(array_merge(array($profileDb), $user->getProfiles()->toArray())));
                } else {
                    $user->setProfiles(new ArrayCollection(array($profileDb)));
                }
            }

            $this->addReference("user" . $users[$i], $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 52;
    }
}