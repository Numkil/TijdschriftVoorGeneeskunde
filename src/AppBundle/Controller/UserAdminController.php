<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\Type\ProfileEditFormType;
use AppBundle\Form\Type\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/admin/viewuser/{userid}/", name="viewSpecificUser")
     */
    public function viewSpecificUserAction($userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        return $this->render('FOSUserBundle::Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/admin/createuser/", name="createUser")
     */
    public function createUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fosusermanager = $this->container->get('fos_user.user_manager');

        $user = $fosusermanager->createUser();
        $user->setEnabled(true);
        $form = $this->createForm(new RegistrationFormType('AppBundle\Entity\User'), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $fosusermanager->updateUser($user);

            $this->addFlash(
                'notice', 'The profile has been created'
            );

            return $this->redirectToRoute('userOverview');
        }

        return $this->render('FOSUserBundle::Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/admin/changepassworduser/{userid}/", name="changePasswordSpecificUser")
     */
    public function changePasswordSpecificUserAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $password = array('plainPassword' => '');
        $form = $this->createFormBuilder($password)
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'New password'),
                'second_options' => array('label' => 'Repeat password'),
                'invalid_message' => 'password.mismatch',
            ))->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $usermanager = $this->get('fos_user.user_manager');
            $user->setPlainPassword($request->request->all()['form']['plainPassword']['first']);
            $usermanager->updateUser($user);

            $this->addFlash(
                'notice', 'The password has been changed'
            );
            return $this->redirectToRoute('viewSpecificUser', array( 'userid' => $userid ));
        }

        return $this->render('::admin/changepassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
     * @Route("/admin/edituser/{userid}/", name="editSpecificUser")
     */
    public function editSpecificUserAction(Request $request, $userid)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $form = $this->createForm(new ProfileEditFormType('AppBundle\Entity\User'), $user);
        $form->remove('current_password');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash(
                'notice', 'The profile has been updated'
            );
            return $this->redirectToRoute('viewSpecificUser', array( 'userid' => $userid ));
        }

        return $this->render('FOSUserBundle::Profile/edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
     * @Route("/admin/deleteuser/{userid}/", name="deleteSpecificUser")
     */
    public function deleteSpecificUserAction(Request $request, $userid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('userOverview');
    }
}
