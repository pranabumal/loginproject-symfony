<?php

namespace umal\userBundle\Controller;

use umal\userBundle\Entity\user;
use umal\userBundle\Form\userType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{

//    public function loginAction(Request $request)
//    {
//        $users = new user();
//        $form = $this-> createForm(new userType(false,false),$users);
//        if($request->getMethod()=='POST')
//        {
//            $form->submit($request);
//            if($form->isValid())
//            {
//                $username = $users->getUsername();
//                $password = $users->getpassword();
//                $session = new Session();
//                $session->set('username', $username);
//                $session->set('password', $password);
//                return $this->redirect($this->generateUrl('user_info'));
//            }
//                return $this->redirect($this->generateUrl('user_homepage'));
//        }
//            return $this->render('userBundle:Default:login.html.twig', array(
//            'form' => $form->createView()
//        ));
//    }

    public function infoAction()
    {
        $session = new Session();
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository('userBundle:user');

        $user=$repository->findOneBy(array(
            'username'=> $session->get('username'),
            'password'=> $session->get('password'),
        ));
        if(isset($user))
        {
            return $this->render('userBundle:Default:info.html.twig', array(
                'user'=> $user
            ));
        }
        return $this->redirect($this->generateUrl('fontend_homepage'));
    }

    public function signupAction(Request $request)
    {
        $users = new user();
        $form = $this->createForm(new userType(true,false),$users);
        if ($request->getMethod() == 'POST')
        {
            $form->submit($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($users);
                $em->flush();
                return $this->redirect($this->generateUrl('fontend_homepage'));
            }
        }
             return $this->render('FontendBundle:Default:index.html.twig', array(
                    'form' => $form->createView(),
                    'function'=> 'signup'
                ));
    }


    public function editAction(Request $request, user $users)
    {

            $form = $this->createForm(new userType(true,true), $users);
            if ($request->getMethod() == 'POST')
            {
                $form->submit($request);
                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($users);
                    $em->flush();
                   $session = new Session();
                   if ($users->getUsername()==$session->get('username')) {
                       return $this->redirect($this->generateUrl('user_info'));
                   }
                    return $this->redirect($this->generateUrl('user_list'));
                }
            }
            return $this->render('userBundle:Default:edit.html.twig', array(

                'form' => $form->createView()
            ));
    }
    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository('userBundle:user');
        $users = $repository->findAll();

        return $this-> render('userBundle:Default:list.html.twig',array('users'=>$users,
        ));
    }


    public function logoutAction()
    {
        $session = new Session();
        $session->clear();
        return $this->redirect($this->generateUrl('fontend_homepage'));
    }

    public function deleteAction($id)
    {
         if($id!=0) {
             $em = $this->getDoctrine()->getEntityManager();
             $users = $em->getRepository('userBundle:user')->find($id);
             $em->remove($users);
             $em->flush();
             return $this->redirect($this->generateUrl('user_list'));
         }
        return $this->redirect($this->generateUrl('user_list'));
    }
}
