<?php

namespace umal\FontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use umal\userBundle\Entity\user;
use umal\userBundle\Form\userType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $users = new user();
        $form = $this-> createForm(new userType(false,false),$users);
        if($request->getMethod()=='POST')
        {
            $form->submit($request);
            if($form->isValid())
            {
                $username = $users->getUsername();
                $password = $users->getpassword();
                $session = new Session();
                $session->set('username', $username);
                $session->set('password', $password);
                return $this->redirect($this->generateUrl('user_info'));
            }
            return $this->redirect($this->generateUrl('fontend_homepage'));
        }
        return $this->render('FontendBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'function'=>'login'
        ));
    }
}
