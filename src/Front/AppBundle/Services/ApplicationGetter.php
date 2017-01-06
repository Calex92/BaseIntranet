<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 06/01/2017
 * Time: 14:24
 */

namespace Front\AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Front\UserBundle\Entity\User;

class ApplicationGetter
{
    private $entityManager;

    /**
     * ApplicationGetter constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getAllApplication(User $user) {

        $jsonContent = (file_get_contents("http://vanina/external_application.php?login=".$user->getUsername()."&password=".$this->getCryptedKey()));
        //This is used to convert into UTF8
        $jsonContent = mb_convert_encoding($jsonContent, 'UTF-8',
            mb_detect_encoding($jsonContent, 'UTF-8, ISO-8859-1', true));

        /* For each external apps, I get the unique Id to do the DB request */
        $codes = array();
        foreach ((array) json_decode($jsonContent) as $externalApp) {
            $codes[] = $externalApp->uniqueId;
        }

        return $this->entityManager->getRepository("FrontAppBundle:Application")->getUserApplication($codes);
    }

    public function getCryptedKey() {
        $key = "le exigue, Ou l'obese jury mur Fete l'hai volapuk, ane ex aequo au whist, otez ce voeu decu. Vieux pelage que  de boeuf au 
        wallon, de graphie en kit mais bref. Portez ce vieux whiskueux. Vif P DG mentor, exhibez la squaw jockey. Juge, flambez l'exquis 
        patchwork d'Yvon.Voyez ce jeu exquis wallon, de graphie en kit mais bref. Portez ce vieux whisky au juge blond qui fumephyr, 
        prefere les jattes de kiwis. Mon pauvre zebu ankylose choque eux whisky au juge bloois ton wagon jaune. Perchez dix, vingt woks. 
        Qu y flambe je ? Le moujik equipe de faux breitschwanz voyage. Kiwi fade";

        $length = 20;
        $today = date("m.y.d"); // e.g. "03.10.01"
        return substr(hash('md5', $key . $today), 0, $length); // Hash it
    }
}