<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 20/12/2016
 * Time: 15:16
 */

namespace Front\DomainBundle\Controller;


use Front\DomainBundle\Entity\Catalog;
use Front\DomainBundle\Form\Type\CatalogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CatalogController extends Controller
{
    public function indexAction($page) {
        $nbPerPage  = 20;
        $catalogs   = $this->getDoctrine()->getRepository("FrontDomainBundle:Catalog")->getPaginator($page, $nbPerPage);

        $nbPages = ceil(count($catalogs) / $nbPerPage);
        // If the page doesn't exist, throw an Exception
        if ($page > $nbPages) {
            $this->get("session")->getFlashBag()->add("danger", "La page sélectionnée n'existe pas");
            return $this->redirectToRoute("domain_manager_catalog_index", array("page" => 1));
        }

        return $this->render("FrontDomainBundle:Catalog:index.html.twig", array(
            "catalogs"  => $catalogs,
            "page"      => $page,
            "nbPages"   => $nbPages
        ));
    }

    public function addAction(Request $request) {
        $catalog = new Catalog();
        $form = $this->get("form.factory")->create(CatalogType::class, $catalog);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $catalog->setCreator($this->getUser());
            $catalog->setCreationDate(new \DateTime());

            $em->persist($catalog);
            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le catalogue a bien été ajouté");
            return $this->redirectToRoute("domain_manager_catalog_index");
        }

        return $this->render('FrontDomainBundle:Catalog:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modifyAction(Request $request, $id) {
        $catalog = $this->getDoctrine()->getRepository("FrontDomainBundle:Catalog")->find($id);
        $form = $this->get("form.factory")->create(CatalogType::class, $catalog);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $catalog->setCreator($this->getUser());
            $catalog->setCreationDate(new \DateTime());

            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le catalogue a bien été modifié");
            return $this->redirectToRoute("domain_manager_catalog_index");
        }

        return $this->render('@FrontDomain/Catalog/modify.html.twig', array(
            'form' => $form->createView(),
            'catalog' => $catalog
        ));
    }

    /**
     * This function displays the catalogs on the left and right of the front pannel.
     * This is only called though a "renderController" atm
     * @param boolean $isLeft
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($isLeft) {
        $catalogs = $this->getDoctrine()->getRepository("FrontDomainBundle:Catalog")->getFromSide($isLeft);


        return $this->render("@FrontDomain/Catalog/view.html.twig", array("catalogs" => $catalogs));
    }
}