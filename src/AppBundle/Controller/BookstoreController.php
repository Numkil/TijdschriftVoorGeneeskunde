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

        return $this->render('bookstore/index.html.twig', array('bookstores' => $books));
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

        return $this->render('bookstore/new.html.twig', $parameters);
    }

    /**
     * @Route("/bookstore/update/{id}", name="updateBookstore")
     */
    public function updateBookstoreAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $bookstore = $em->getRepository('AppBundle:Bookstore')->find($id);

        if (!$bookstore) {
            throw $this->createNotFoundException(
                'No bookstore found for id '.$id
            );
        }

        $form = $this->createForm(new BookstoreFormType(), $bookstore);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('bookstoreOverview');
        }

        $parameters = array(
            'bookstore' => $form->createView(),
            'bookstoreID' => $bookstore->getId(),
        );

        return $this->render('bookstore/new.html.twig', $parameters);
    }

    /**
     * @Route("/bookstore/remove/{id}", name="removeBookstore")
     */
    public function removeBookstoreAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $bookstore = $em->getRepository('AppBundle:Bookstore')->findOneById($id);
        $em->remove($bookstore);
        $em->flush();

        return $this->redirectToRoute('bookstoreOverview');
    }
}
