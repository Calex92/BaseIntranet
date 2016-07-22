<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = array( "achat" =>"Achat",
            "ebusiness"     => "E-business",
            "finances"      => "Finances",
            "giss"          => "GISS",
            "grandscomptes" => "Grands Comptes",
            "informatique"  => "Informatique",
            "juridique"     => "Juridique",
            "logistique"    => "Logistique",
            "marketing"     => "Marketing",
            "metiers"       => "Métiers",
            "organisation"  => "Organisation",
            "perfco"        => "Perf'Co",
            "qualite"       => "Qualité",
            "rh"            => "R.H.",
            "reseau"        => "Réseau");

        $domainsCount = array("juridique" => 1,
            "informatique" => 1);

        $documents = array();

        $document = array("author" => "P. Firmin",
            "title"  => "SAM Equivalences Produits",
            "type"   => "application vnd",
            "creationDate"  => \DateTime::createFromFormat("d M Y", "18 September 2015"),
            "fileName"  => "Transposition SAM.xlsx",
            "location"  => "bundles/front/documents/7692.xlsx",
            "domain"    => "Juridique");
        if ($domain == "all" || $domains[$domain] == $document["domain"])
            array_push($documents, $document);

        $document = array("author" => "T. Boulanger",
            "title"  => "Chartre informatique",
            "type"   => "application msw",
            "creationDate"  => \DateTime::createFromFormat("d M Y", "10 December 2014"),
            "fileName"  => "charte informatique.doc",
            "location"  => "bundles/front/documents/5760.doc",
            "domain"    => "Informatique");
        if ($domain == "all" || $domains[$domain] == $document["domain"])
            array_push($documents, $document);

        return $this->render('FrontAppBundle:Documents:index.html.twig', array("domains" => $domains,
            "documents" => $documents,
            "domainsCount" => $domainsCount));
    }
}
