<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NoticeController extends Controller{
	
	/**
	* @Route("/noticeOverview", name="noticeOverview")
	*/
	public function indexAction(){
		return $this->render('notice/index.html.twig');
	}
}