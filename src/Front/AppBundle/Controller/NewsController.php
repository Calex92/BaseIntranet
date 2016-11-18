<?php

namespace Front\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("FrontAppBundle:Domain")->findBy(array("active" => 1));
        $news = $this->getDoctrine()->getRepository("FrontAppBundle:News")->getActiveNews($domain);

        return $this->render('@FrontApp/News/index.html.twig', array("domains" => $domains,
            "news" => $news));
    }

    public function viewAction(Request $request, $id) {
        $news = $this->getDoctrine()->getRepository("FrontAppBundle:News")->find($id);
        //I use the LastRouteListener to know what was the last route used
        $referer = $request->getSession()->get("last_route");
        return $this->render('@FrontApp/News/view.html.twig', array("news" => $news, "referer" => $referer));
    }
}
