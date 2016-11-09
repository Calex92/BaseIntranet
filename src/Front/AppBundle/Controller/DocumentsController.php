<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("FrontAppBundle:Domain")->findBy(array("active" => 1));
        $documents = $this->getDoctrine()->getRepository("FrontAppBundle:Document")->getActiveDocument($domain);

        return $this->render('FrontAppBundle:Documents:index.html.twig', array("domains" => $domains,
            "documents" => $documents));
    }
}
