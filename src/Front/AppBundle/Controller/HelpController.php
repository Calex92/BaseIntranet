<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/01/2017
 * Time: 14:38
 */

namespace Front\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelpController extends Controller
{
    public function indexAction() {
        /** @var \Swift_Mime_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom(array("alexandre.castelain@orexad.com" => "Je suis un genie"))
            ->setTo('calex92@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/test.html.twig'
                ),
                'text/html'
            )
            ->setCharset('utf-8')
        ;
        $this->get('mailer')->send($message);
        return $this->render("FrontAppBundle:Help:index.html.twig");
    }
}