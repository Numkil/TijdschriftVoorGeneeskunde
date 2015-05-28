<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Article;
use AppBundle\Service\ArticleParser;

class ArticleController extends Controller{

	
	
	/**
	* @Route("/article/", name="articleOverview")
	*/
	public function indexArticleAction(){
		$articleParser = $this->get('article_parser');

		$articles = $articleParser->fetchAllArticles();

		$paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            10 /* max number of elements per page*/
        );

		return $this->render('article/index.html.twig', array('pagination'=>$pagination));
	}

	
	



}