<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("Domain.php")->findBy(array("active" => 1));
        $news = $this->getDoctrine()->getRepository("FrontAppBundle:News")->getActiveNews($domain);

        return $this->render('@FrontApp/News/index.html.twig', array("domains" => $domains,
            "news" => $news));
    }

    public function viewAction(/*$id*/) {
        return $this->render('@FrontApp/News/view.html.twig');
    }
}
