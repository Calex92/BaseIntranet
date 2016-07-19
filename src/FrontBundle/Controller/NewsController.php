<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction($domain)
    {
        //These domains must be got from the DB. Get the one with news in them, the main page won't be too
        //charged this way. The domains always have a good name and a slug, to display it in the URL
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

        $domainsCount = array("achat" => 1,
            "giss" => 1,
            "perfco" => 1);

        //Now, I create fake news, 2 of them
        $news = array();
        $new = array("title" => "Lorem Ipsum",
            "domain" => "Achat",
            "text" => "Pellentesque hendrerit, massa at euismod ullamcorper, enim tortor tincidunt sapien, nec convallis nisl mauris eu tellus. Nunc euismod ultrices viverra. Sed in mi ligula, a tincidunt leo. In hac habitasse platea dictumst. Quisque at augue quis tortor euismod tincidunt nec id magna. Vestibulum eu nunc at odi.",
            "author" => "G. Loncke",
            "image" => "http://random-ize.com/lorem-ipsum-generators/lorem-ipsum/lorem-ipsum.jpg",
            "creationDate" => \DateTime::createFromFormat("d M Y", "09 July 2016"),
            "id" => 0);
        if ($domain=="all" || $domains[$domain] == $new['domain'] )
            array_push($news, $new);
        $new = array("title" => "Pourquoi l'utiliser?",
            "domain" => "Perf'Co",
            "text" => "On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).",
            "author" => "A. Castelain",
            "image" => "http://www.jusderaisin.com/wp-content/uploads/2014/06/Content-is-like-water-1980.jpg",
            "creationDate" => \DateTime::createFromFormat("d M Y", "19 June 2016"),
            "id" => 1);
        if ($domain=="all" || $domains[$domain] == $new['domain'])
            array_push($news, $new);
        $new = array("title" => "Petit texte",
            "domain" => "GISS",
            "text" => "Nulla aliquet convallis tempus. Phasellus sapien turpis, tincidunt a interdum a, sag.",
            "author" => "E. Dhaussy",
            "image" => "https://www.newton.ac.uk/files/covers/968361.jpg",
            "creationDate" => \DateTime::createFromFormat("d M Y", "03 January 2014"),
            "id" => 0);
        if ($domain=="all" || $domains[$domain] == $new['domain'] )
            array_push($news, $new);


        return $this->render('FrontBundle:News:index.html.twig', array("domains" => $domains,
            "news" => $news,
            "domainsCount" => $domainsCount));
    }
}
