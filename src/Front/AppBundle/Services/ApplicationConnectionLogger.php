<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/01/2017
 * Time: 09:40
 */

namespace Front\AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Front\AppBundle\Entity\Application;
use Front\AppBundle\Entity\ApplicationConnectionStatistics;
use Front\UserBundle\Entity\User;

class ApplicationConnectionLogger
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

    public function logAccess(Application $application, User $user) {
        $applicationConnectionStatistic = new ApplicationConnectionStatistics();
        $browserInfo        = get_browser(null, true);
        $profileNamePrefered    = $user->getProfilePrefered($application->getCode())->getProfile()->getName();
        $applicationConnectionStatistic->setApplication($application)
            ->setUser($user)
            ->setDate(new \DateTime())
            ->setProfileName(($profileNamePrefered != null) ? $profileNamePrefered : "Aucun profil défini pour une application externe")
            ->setBrowser($this->getBrowserName($_SERVER["HTTP_USER_AGENT"])." ".$browserInfo["version"])
            ->setIpAdress($_SERVER['REMOTE_ADDR'])
            ->setOperatigSystem($this->getOS($_SERVER["HTTP_USER_AGENT"])." / ".$browserInfo["platform_description"]);

        $this->entityManager->persist($applicationConnectionStatistic);
        $this->entityManager->flush();
    }

    private function getBrowserName($user_agent) {
        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
        elseif (strpos($user_agent, 'Edge')) return 'Edge';
        elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
        elseif (strpos($user_agent, 'Safari')) return 'Safari';
        elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

        return 'Other';
    }

    private function getOS($user_agent) {
        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }
        return $os_platform;
    }
}
