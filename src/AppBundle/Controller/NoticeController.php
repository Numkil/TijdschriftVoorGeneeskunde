<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\NoticeFormType;
use AppBundle\Entity\Notice;
class NoticeController extends Controller{

    /**
     * @Route("/admin/notice/", name="adminOverview")
     */
    public function indexAction(Request $request){
        $notices = $this->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->findBy(array(), array('creationDate' => 'DESC'));

        return $this->render('notice/index.html.twig', array('notices' => $notices));
    }


    /**
     * @Route("/notice/", name="noticeOverview")
     */
    public function noticeOverviewAction(Request $request){
        //For pagination we used the KnpPaginatorBundle --> https://github.com/KnpLabs/KnpPaginatorBundle/blob/master/Resources/doc/templates.md

        $notices = $this->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->findBy(array(), array('creationDate' => 'DESC'));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $notices,
            $request->query->getInt('page', 1),
            5 /* max number of elements per page*/
        );

        return $this->render('notice/noticeOverview.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/notice/new/", name="createNotice")
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

    /**
     * @Route("/admin/notice/update/{id}", name="updateNotice")
     */
    public function updateNoticeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $notice = $em->getRepository('AppBundle:Notice')->find($id);

        if (!$notice) {
            throw $this->createNotFoundException(
                'No notice found for id '.$id
            );
        }

        $form = $this->createForm(new NoticeFormType(), $notice);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('adminOverview');
        }

        $parameters = array(
            'notice' => $form->createView(),
        );

        return $this->render('notice/updateNotice.html.twig', $parameters);
    }

    /**
     * @Route("/admin/notice/remove/{id}", name="removeNotice")
     *
     */
    public function removeNoticeAction($id){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Notice n WHERE n.id = '.$id);
        $query->execute();

        return $this->redirectToRoute('adminOverview');
    }
}
