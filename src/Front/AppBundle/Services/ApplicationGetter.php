<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 06/01/2017
 * Time: 14:24
 */

namespace Front\AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Front\AppBundle\Entity\Application;
use Front\AppBundle\Entity\Profile;
use Front\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class ApplicationGetter
{
    private $entityManager;
    private $flashBag;
    private $helpInfoCode;

    /**
     * ApplicationGetter constructor.
     * @param EntityManager $entityManager
     * @param FlashBag $flashBag
     * @param $helpInfoCode
     */
    public function __construct(EntityManager $entityManager, FlashBag $flashBag, $helpInfoCode)
    {
        $this->entityManager = $entityManager;
        $this->flashBag      = $flashBag;
        $this->helpInfoCode  = $helpInfoCode;
    }

    /**
     * @param User $user
     * @return array
     */
    private function getAllApplication(User $user) {
        $externalApplications = $this->getExternalApplication($user);
        $internalApplications = $this->getInternalApplication($user);

        $applications = array_merge($internalApplications, $externalApplications);

        //sort alphabetically
        uasort($applications, function(Application $a,Application $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $applications;
    }

    /**
     * Get the applications the user can access
     * @param User $user
     * @return Application[]
     */
    public function getApplicationAccessible(User $user) {
        /* If the user doesn't have any agency (so no principal agency), he can't access the applications to prevent any bug */
        if ($user->getAgencyPrincipal()->getId() === NULL) {
            $applications = $this->entityManager->getRepository("FrontAppBundle:Application")->findBy(array("code" => $this->helpInfoCode));
            $this->flashBag->add("danger", "Vous n'êtes affecté à aucune agence, veuillez créer une demande sur le Help informatique pour régler ce problème.");
        }
        else {
            /* If there's a bug with the connexion to the old Isidore, we let the access to the current applications */
            try {
                $applications = $this->getAllApplication($user);
            } catch (\Exception $e) {
                $applications = $this->getInternalApplication($user);
                $this->flashBag->add("danger", "Votre login ne correspond à aucun utilisateur sur l'ancien Isidore");
            }
        }
        return $applications;
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

    /**
     * Get the application from Isidore and transform them into application we can use
     * @param User $user
     * @return array
     */
    private function getExternalApplication(User $user) {
        $jsonContent = (file_get_contents("http://vanina/external_application.php?login=".$user->getUsername()."&password=".$this->getCryptedKey()));
        //This is used to convert into UTF8
        $jsonContent = mb_convert_encoding($jsonContent, 'UTF-8',
            mb_detect_encoding($jsonContent, 'UTF-8, ISO-8859-1', true));

        /* For each external apps, I get the unique Id to do the DB request */
        $codes = array();
        foreach ((array) json_decode($jsonContent) as $externalApp) {
            $codes[] = $externalApp->uniqueId;
        }

        return $this->entityManager->getRepository("FrontAppBundle:ApplicationExternal")->getUserApplication($codes);
    }

    /**
     * Get the applications from the app
     * @param User $user
     * @return array
     */
    private function getInternalApplication(User $user) {
        $internalApplications = array();

        foreach ($user->getProfilesApplication() as $profileApplication) {
            /** @var Profile $profileApplication */
            $internalApplications[] = $profileApplication->getApplication();
        }
         return array_unique($internalApplications);
    }

    public function getApplicationNotAccessible(array $applicationAccessible) {
        $applications = $this->entityManager->getRepository("FrontAppBundle:Application")->findAll();

        return array_diff($applications, $applicationAccessible);
    }
}
