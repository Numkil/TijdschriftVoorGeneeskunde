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
    public function indexArticleAction(Request $request){
        $articleParser = $this->get('article_parser');

        $articles = $articleParser->fetchAllArticles();
        $articles = array_reverse($articles);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            10 /* max number of elements per page*/
        );

        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('titel', 'text', array(
                'required' => false,
            ))
            ->add('subtitel', 'text', array(
                'required' => false,
            ))

            ->add('vakgebieden', 'text', array(
                'required' => false,
            ))
            ->add('auteur', 'text', array(
                'required' => false,
            ))
            ->add('trefwoorden', 'text', array(
                'required' => false,
            ))
            ->add('search', 'submit')
            ->getForm();;
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $articles = $articleParser->fetchAllArticlesForQuery($data);
            $articles = array_reverse($articles);
            $pagination = $paginator->paginate(
                $articles,
                $request->query->getInt('page', 1),
                10 /* max number of elements per page*/
            );

        }
        return $this->render('article/index.html.twig',
            array(
                'pagination' => $pagination,
                'form' => $form->createView(),
            ));
    }
}
