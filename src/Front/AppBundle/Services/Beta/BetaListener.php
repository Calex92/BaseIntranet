<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 14/02/2017
 * Time: 11:31
 */

namespace Front\AppBundle\Services\Beta;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    private $environment;
    private $betaHtmlAdder;

    public function __construct(BetaHtmlAdder $betaHtmlAdder, $environment)
    {
        $this->environment = $environment;
        $this->betaHtmlAdder = $betaHtmlAdder;
    }

    public function processBeta(FilterResponseEvent $event) {
        //If it's not the main request, we don't need to do anything (like when we call the method "renderController"
        if (!$event->isMasterRequest() || $this->environment == "prod") {
            return;
        }

        $response = $this->betaHtmlAdder->addBeta($event->getResponse(), $this->environment);
        $event->setResponse($response);
    }
}
