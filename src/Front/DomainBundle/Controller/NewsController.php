<?php

namespace Front\DomainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->findBy(array("active" => 1));
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->getActiveNews($domain);

        return $this->render('FrontDomainBundle:News:index.html.twig', array("domains" => $domains,
            "news" => $news));
    }

    public function viewAction($id) {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->find($id);

        return $this->render('FrontDomainBundle:News:view.html.twig', array("news" => $news));
    }
}
