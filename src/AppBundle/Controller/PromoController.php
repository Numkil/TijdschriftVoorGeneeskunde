<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Promo;

class PromoController extends Controller{

	/**
     * @Route("/admin/promo/", name="promoOverview")
     */
    public function indexPromoAction(Request $request){
    	 $promos = $this->getDoctrine()
            ->getRepository('AppBundle:Promo')
            ->findBy(array(), array('id' => 'ASC'));

        return $this->render('promo/index.html.twig', array('promos' => $promos));
    }

    /**
     * @Route("/admin/promo/new/", name="createPromo")
     */
    public function createPromoAction(Request $request, $code){
        print($code);
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