<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 14/02/2017
 * Time: 11:38
 */

namespace Front\AppBundle\Services\Beta;


use Symfony\Component\HttpFoundation\Response;

class BetaHtmlAdder
{
    public function addBeta(Response $response, $domain) {
        $content = $response->getContent();
        $html = '
            <div class="beta-site">
                Vous n\'êtes actuellement pas sur le site de production! Les données présentes ne seront pas forcément
                identiques à celle de votre environnement de travail habituel.<br/>
                Si cela vous pose un problème pour les tests, n\'hésitez pas à nous prévenir via le Help OI. 
                Vous êtes sur le site de '.$domain.'.</div>';

        $content = str_replace(
            '<body>',
            '<body>'.$html,
            $content
        );

        $response->setContent($content);
        return $response;
    }
}
