<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
class UserAdminController extends Controller{

	/**
	* @Route("/admin/", name="userOverview")
	*/
	public function indexAction(){

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('admin/index.html.twig', array(
            'users' => $users,
        ));
	}

}
