<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 24/11/2016
 * Time: 10:01
 */

namespace Front\DomainBundle\Controller;


use Front\DomainBundle\Entity\News;
use Front\DomainBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AppController extends Controller
{
    public function indexAction() {
        return $this->redirectToRoute("domain_manager_news");
    }

    public function newsAction() {
        $news = $this->getDoctrine()->getRepository("FrontDomainBundle:News")->findAll();

        return $this->render('FrontDomainBundle:App:news.html.twig', array("news" => $news));
    }

    public function addNewsAction(Request $request) {
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

        return $this->render('@FrontDomain/App/addnews.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function documentAction() {

    }

    public function topMenuAction($route) {
        $menus = array();
        $menus[] = array("route" => "domain_manager_news",
            "name" => "News",
            "active" => in_array($route,
                array('domain_manager_news'))? "active": "");

        $menus[] = array("route" => "news_index",
            "name" => "Documents",
            "active" => "");

        foreach ($menus as $key => &$val) {
            if ($val['route'] == $route) {
                $val['active'] = "active";
            }
        }

        return $this->render('@AdminApp/Base/topMenu.html.twig', array("menus" => $menus));
    }
}