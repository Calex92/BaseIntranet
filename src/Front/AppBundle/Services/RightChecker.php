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
     * @param $application_id
     * @param $rightName
     * @return boolean
     */
    public function userCanSee(User $user, $application_id, $rightName) {
       foreach ($user->getRights($application_id) as $right) {
           /** @var Right $right */
           if ($right->getId() == $rightName)
               return true;
       }
       return false;
    }

}