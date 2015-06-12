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
            ->add('jaar', 'collot_datetime', array(
                'pickerOptions' => array(
                    'format' => 'yyyy',
                    'startView' => 'decade',
                    'minView' => 'decade',
                ),
                'required' => false,
                'input' => 'string',
            ))
            ->add('boekbespreking', 'checkbox', array(
                'required' => false,
            ))
            ->add('search', 'submit')
            ->getForm();;
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $articles = $articleParser->fetchAllArticlesForQuery($data);
            $articles = array_reverse($articles);
        }
        return $this->render('article/index.html.twig',
            array(
                'articles' => $articles,
                'form' => $form->createView(),
            ));
    }
}
