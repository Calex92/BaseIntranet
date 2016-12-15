<?php

namespace Front\DomainBundle\Controller;

use Front\DomainBundle\Entity\News;
use Front\DomainBundle\Form\Type\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController extends Controller
{
    public function indexAction($domain, $page)
    {
        $nbPerPage = 4;
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->getActiveWithChildrenNews();
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->getActiveNews($domain, $page, $nbPerPage);

        $nbPages = ceil(count($news) / $nbPerPage);
        // If the page doesn't exist, throw an Exception
        if ($page > $nbPages) {
            $this->get("session")->getFlashBag()->add("danger", "La page sélectionnée n'existe pas");
            //throw $this->createNotFoundException("La page ".$page." n'existe pas.");
            return $this->redirectToRoute("news_index", array("domain" => "all", "page" => 1));
        }

        return $this->render('FrontDomainBundle:News:index.html.twig',
            array("domains"     => $domains,
                    "news"      => $news,
                    "nbPages"   => $nbPages,
                    "page"      => $page));
    }

    public function viewAction($id) {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->find($id);

        return $this->render('FrontDomainBundle:News:view.html.twig', array("news" => $news));
    }

    public function modifyAction(Request $request, $id) {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->find($id);
        $form = $this->get("form.factory")->create(NewsType::class, $news);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $news->setCreator($this->getUser());
            $news->setCreationDate(new \DateTime());

            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "La news a bien été modifiée");
            return $this->redirectToRoute("domain_manager_news");
        }

        return $this->render('@FrontDomain/News/modify.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    public function listAction() {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->findAll();

        return $this->render('FrontDomainBundle:News:list.html.twig', array("news" => $news));
    }

    public function addAction(Request $request) {
        $news = new News();
        $form = $this->get("form.factory")->create(NewsType::class, $news);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $news->setCreator($this->getUser());
            $news->setCreationDate(new \DateTime());

            $em->persist($news);
            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "La news a bien été ajoutée");
            return $this->redirectToRoute("domain_manager_news");
        }

        return $this->render('@FrontDomain/News/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
