<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\NoticeFormType;
use AppBundle\Entity\Notice;
class NoticeController extends Controller{
	
	/**
	* @Route("/notice", name="noticeOverview")
	*/
	public function indexAction(){
		$notices = $this->getDoctrine()
			->getRepository('AppBundle:Notice')
			->findBy(array(), array('creationDate' => 'DESC'));

		$parameters = array(
			"notices" => $notices
			);

		return $this->render('notice/index.html.twig', $parameters);
	}

	/**
	* @Route("/notice/new", name="createNotice")
	*/
	public function createNoticeAction(Request $request){
		$noticeObject = new Notice();

		$form = $this->createForm(new NoticeFormType(), $noticeObject);

		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($noticeObject);
			$em->flush();
        
			return $this->redirectToRoute('noticeOverview');
	    }

		$parameters = array(
							"notice" => $form->createView(),
						);

		return $this->render('notice/newNotice.html.twig', $parameters);
	}


}