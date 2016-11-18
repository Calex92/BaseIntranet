<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 18/11/2016
 * Time: 14:11
 */

namespace Front\AppBundle\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class LastRouteListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Do not save subrequests
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        if ($routeName[0] == '_') {
            return;
        }
        $routeData = ['name' => $routeName, 'params' => $routeParams];

        // Do not save same matched route twice
        $thisRoute = $session->get('this_route', []);
        if ($thisRoute == $routeData) {
            return;
        }

        if ($routeName != "fos_js_routing_js") {
            $session->set('last_route', $thisRoute);
            $session->set('this_route', $routeData);
        }
        else if (empty($routeData)) {
            //If there's no previous route, we go to the "first" page, the index
            $session->set('last_route', ['name' => 'front_app', 'params' => '']);
            $session->set('this_route', ['name' => 'front_app', 'params' => '']);
        }
    }
}