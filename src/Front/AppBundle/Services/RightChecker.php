<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 16:26
 */

namespace Front\AppBundle\Services;


use Front\AppBundle\Entity\Right;
use Front\UserBundle\Entity\User;

class RightChecker
{
    /**
     *
     * @param User $user
     * @param $application_name
     * @param $rightName
     * @return boolean
     */
    public function userCanSee(User $user, $application_name, $rightName) {
       foreach ($user->getRights($application_name) as $right) {
           /** @var Right $right */
           if ($right->getName() == $rightName)
               return true;
       }
       return false;
    }

}