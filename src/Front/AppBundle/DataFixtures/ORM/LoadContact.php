<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/09/2016
 * Time: 10:23
 */

namespace Front\AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Front\AppBundle\Entity\Contact;

class LoadContact extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = array("pfirmin", "gloncke", "acallens", "asergent", "mcastelain");
        $phones = array($users[0] => "0320799807",
            $users[1] => "0320769800",
            $users[2] => "0708090504",
            $users[3] => "0230040556",
            $users[4] => "056331578");

        $mobiles = array($users[0] => "0320799807",
            $users[1] => "0798364502",
            $users[2] => "0405090807",
            $users[3] => "",
            $users[4] => "0498367983");

        $faxes = array($users[0] => "0102030405",
            $users[1] => "",
            $users[2] => "4587985652",
            $users[3] => "",
            $users[4] => "003256331578");

        for ($i = 0; $i < count($users) ; $i++) {
            $contact = new Contact();
            $contact->setPhone($phones[$users[$i]]);
            $contact->setMobilePhone($mobiles[$users[$i]]);
            $contact->setFax($faxes[$users[$i]]);

            $this->addReference("user-contact".$users[$i], $contact);
            $manager->persist($contact);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}