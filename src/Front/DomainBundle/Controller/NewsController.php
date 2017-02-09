<?php

namespace Front\DomainBundle\Controller;

use Front\DomainBundle\Entity\News;
use Front\DomainBundle\Form\Type\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController extends Controller
{
    public function viewListAction($domain, $page)
    {
        $nbPerPage = 4;
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->getActiveWithChildren("FrontDomainBundle:News");
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->getActiveNews($domain, $page, $nbPerPage);

        $nbPages = ceil(count($news) / $nbPerPage);
        // If the page doesn't exist, throw an Exception
        if ($page > $nbPages) {
            $this->get("session")->getFlashBag()->add("danger", "La page sélectionnée n'existe pas");
            return $this->redirectToRoute("domain_manager_news_list_view", array("domain" => "all", "page" => 1));
        }

        return $this->render('FrontDomainBundle:News:viewList.html.twig',
            array("domains"     => $domains,
                    "news"      => $news,
                    "nbPages"   => $nbPages,
                    "page"      => $page));
    }

    public function viewAction($id) {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->find($id);

        return $this->render('FrontDomainBundle:News:view.html.twig', array("news" => $news));
    }

    /**
     * @Security("has_role('ROLE_DOMAIN_NEWS_DOCUMENT')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function modifyAction(Request $request, $id) {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->find($id);
        $form = $this->get("form.factory")->create(NewsType::class, $news, array("user" => $this->getUser()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $news->setCreator($this->getUser());
            $news->setCreationDate(new \DateTime());

            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "La news a bien été modifiée");
            return $this->redirectToRoute("domain_manager_news_index");
        }

        return $this->render('@FrontDomain/News/modify.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    /**
     * @Security("has_role('ROLE_DOMAIN_NEWS_DOCUMENT')")
     * @param $domain
     * @param $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($domain, $page) {
        $nbPerPage  = 20;
        $domains    = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->getActiveWithChildren("FrontDomainBundle:News");
        $news       = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->getActiveNews($domain, $page, $nbPerPage);

        $nbPages = ceil(count($news) / $nbPerPage);
        // If the page doesn't exist, throw an Exception
        if ($page > $nbPages) {
            $this->get("session")->getFlashBag()->add("danger", "La page sélectionnée n'existe pas");
            return $this->redirectToRoute("domain_manager_news_index", array("domain" => "all", "page" => 1));
        }

        return $this->render('FrontDomainBundle:News:index.html.twig', array(
            "news"      => $news,
            "domains"   => $domains,
            "nbPages"   => $nbPages,
            "page"      => $page));
    }

    /**
     * @Security("has_role('ROLE_DOMAIN_NEWS_DOCUMENT')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request) {
        $news = new News();
        $form = $this->get("form.factory")->create(NewsType::class, $news, array("user" => $this->getUser()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $news->setCreator($this->getUser());
            $news->setCreationDate(new \DateTime());

            $em->persist($news);
            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "La news a bien été ajoutée");
            return $this->redirectToRoute("domain_manager_news_index");
        }

        return $this->render('@FrontDomain/News/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
