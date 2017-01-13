<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 12/01/2017
 * Time: 16:32
 */

namespace Admin\AppBundle\Enum;


class RightsEnum
{
    /* The value is the ID of the right in DB */
    const SEE_USER      = 1;
    const UPDATE_USER   = 2;
    const CONNECT_AS_USER       = 13;
    const SEE_GROUP     = 3;
    const UPDATE_GROUP  = 4;
    const SEE_APPLICATION       = 5;
    const UPDATE_APPLICATION    = 6;
    const SEE_AGENCY            = 7;
    const UPDATE_AGENCY         = 8;
    const SEE_REGION    = 9;
    const UPDATE_REGION = 10;
    const SEE_ZONE      = 11;
    const UPDATE_ZONE   = 12;
}