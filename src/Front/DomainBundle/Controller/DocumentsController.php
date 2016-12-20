<?php

namespace Front\DomainBundle\Controller;

use Front\DomainBundle\Entity\Document;
use Front\DomainBundle\Form\Type\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DocumentsController extends Controller
{
    public function indexAction($domain)
    {
        $domains = $this->getDoctrine()->getRepository("FrontDomainBundle:Domain")->findBy(array("active" => 1));
        $documents = $this->getDoctrine()->getRepository("FrontDomainBundle:Document")->getActiveDocument($domain);

        return $this->render('FrontDomainBundle:Documents:index.html.twig', array("domains" => $domains,
            "documents" => $documents));
    }

    public function listAction() {
        $documents = $this->getDoctrine()->getRepository("FrontDomainBundle:Document")->findAll();

        return $this->render("@FrontDomain/Documents/list.html.twig", array("documents" => $documents));
    }

    public function addAction(Request $request) {
        $document = new Document();
        $form = $this->get("form.factory")->create(DocumentType::class, $document);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $document->setCreator($this->getUser());
            $document->setCreationDate(new \DateTime());

            $em->persist($document);
            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le document a bien été ajouté");
            return $this->redirectToRoute("domain_manager_document");
        }

        return $this->render('@FrontDomain/Documents/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modifyAction(Request $request, $id) {
        $document = $this->getDoctrine()->getRepository("FrontDomainBundle:Document")->find($id);
        $form = $this->get("form.factory")->create(DocumentType::class, $document);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $document->setCreator($this->getUser());
            $document->setCreationDate(new \DateTime());

            $em->flush();

            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add("success", "Le document a bien été modifié");
            return $this->redirectToRoute("domain_manager_document");
        }

        return $this->render('@FrontDomain/Documents/modify.html.twig', array(
            'form' => $form->createView(),
            'document' => $document
        ));
    }

}
