<?php

namespace Front\DomainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->findBy(array("active" => 1));
        $documents = $this->getDoctrine()->getRepository("FrontDomainBundle:Document")->getActiveDocument($domain);

        return $this->render('FrontDomainBundle:Documents:index.html.twig', array("domains" => $domains,
            "documents" => $documents));
    }
}
