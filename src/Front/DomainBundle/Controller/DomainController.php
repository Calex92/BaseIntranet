<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 22/12/2016
 * Time: 09:46
 */

namespace Front\DomainBundle\Controller;


use Front\DomainBundle\Entity\Domain;
use Front\DomainBundle\Form\Type\DomainType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DomainController extends Controller
{
    public function indexAction() {
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->findAll();

        return $this->render("FrontDomainBundle:Domain:index.html.twig", array(
            "domains" => $domains));
    }

    public function addAction(Request $request) {
        $domain = new Domain();
        $form = $this->get("form.factory")->create(DomainType::class, $domain);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($domain);
            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le domaine a bien été ajouté");
            return $this->redirectToRoute("domain_manager_domain_index");
        }

        return $this->render('@FrontDomain/Domain/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modifyAction(Request $request, $id) {
        $domain = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->find($id);
        $form = $this->get("form.factory")->create(DomainType::class, $domain);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le domaine a bien été modifié");
            return $this->redirectToRoute("domain_manager_domain_index");
        }

        return $this->render('@FrontDomain/Domain/modify.html.twig', array(
            'form' => $form->createView(),
            'domain' => $domain
        ));
    }
}