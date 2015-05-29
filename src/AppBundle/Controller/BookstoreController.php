<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\BookstoreFormType;
use AppBundle\Entity\Bookstore;

class BookstoreController extends Controller
{
	/**
     * @Route("/bookstore/", name="bookstoreOverview")
     */
    public function indexAction(Request $request){
        $books = $this->getDoctrine()
            ->getRepository('AppBundle:Bookstore')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10 /* max number of elements per page*/
        );

        return $this->render('bookstore/index.html.twig', array('pagination' => $pagination));
    }


    /**
     * @Route("/bookstore/new/", name="createBookstore")
     */
    public function createBookstoreAction(Request $request){
        $bookstoreObject = new Bookstore();

        $form = $this->createForm(new BookstoreFormType(), $bookstoreObject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Have to add address object to database before it can be used as a foreign key in the bookstoreObject
            $em->persist($bookstoreObject->getAddress());
            $em->persist($bookstoreObject);
            $em->flush();

            return $this->redirectToRoute('bookstoreOverview');
        }

        $parameters = array(
            "bookstore" => $form->createView(),
        );

        return $this->render('bookstore/newBookstore.html.twig', $parameters);
    }

}
