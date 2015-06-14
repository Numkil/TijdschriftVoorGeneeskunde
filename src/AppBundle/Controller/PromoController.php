<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Promo;
use AppBundle\Form\Type\PromoFormType;

class PromoController extends Controller{

	/**
     * @Route("/admin/promo/", name="promoOverview")
     */
    public function indexPromoAction(Request $request){
    	$promo = new Promo();

        $form = $this->createForm(new PromoFormType(), $promo);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('promoOverview');
        }

        $parameters = array(
            "promo" => $form->createView(),
        );

        $promos = $this->getDoctrine()
            ->getRepository('AppBundle:Promo')
            ->findBy(array(), array('id' => 'ASC'));

        return $this->render('promo/index.html.twig', array('promos' => $promos, "promo" => $form->createView(),));
    }

    /**
     * @Route("/admin/promo/new/", name="createPromo")
     */
    public function createPromoAction(Request $request){
        $promo = new Promo();

        $form = $this->createForm(new PromoFormType(), $promo);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('promoOverview');
        }

        $parameters = array(
            "promo" => $form->createView(),
        );

        return $this->render('notice/newNotice.html.twig', $parameters);
    }

    /**
     * @Route("/admin/promo/remove/{id}", name="removePromo")
     */
    public function removePromoAction(Request $request, $id){
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Promo p WHERE p.id = '.$id);
        $query->execute();

        return $this->redirectToRoute('promoOverview');
    }
}