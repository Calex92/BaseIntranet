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
    const SEE_USER      = "SeeUsers";
    const UPDATE_USER   = "UpdateUsers";
    const CONNECT_AS_USER       = "ConnectAsUser";
    const SEE_GROUP     = "SeeGroups";
    const UPDATE_GROUP  = "UpdateGroups";
    const SEE_APPLICATION       = "SeeApplications";
    const UPDATE_APPLICATION    = "UpdateApplications";
    const SEE_AGENCY            = "SeeAgencies";
    const UPDATE_AGENCY         = "UpdateAgencies";
    const SEE_REGION    = "SeeRegion";
    const UPDATE_REGION = "UpdateRegion";
    const SEE_ZONE      = "SeeZone";
    const UPDATE_ZONE   = "UpdateZone";
}