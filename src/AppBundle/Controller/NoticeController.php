<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Form\Type\NoticeFormType;
use AppBundle\Entity\Notice;
class NoticeController extends Controller{
	
	/**
	* @Route("/notice/overview", name="noticeOverview")
	*/
	public function indexAction(){
		return $this->render('notice/index.html.twig');
	}

	/**
	* @Route("/notice/new", name="createNotice")
	*/
	public function createNoticeAction(){
		$noticeObject = new Notice();

		$notice = $this->createForm(new NoticeFormType(), $noticeObject);

		$parameters = array(
							"notice" => $notice->createView(),
						);

		return $this->render('notice/newNotice.html.twig', $parameters);
	}

}