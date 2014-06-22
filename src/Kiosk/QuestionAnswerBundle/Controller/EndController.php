<?php

namespace Kiosk\QuestionAnswerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Kiosk\QuestionAnswerBundle\utils\zmq;



class EndController extends Controller
{
    
    /**
     * entry point to the quiz
     * @Route("/end", name="end")
     */    
    public function showAction(Request $request)
    {
        $session = $request->getSession(); 
        $result = 'Correct answers '.$session->get('correct_answers').'. Incorrect answers '.$session->get('incorrect_answers').'';
        zmq::send('The result of the Quiz is. '.$result,'', $session->get('bg_image'));
        $learn = null;
        $form = $this->createFormBuilder($learn)
        ->add('Play again', 'submit') 
        ->getForm();  
        $form->handleRequest($request); 
        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('start'));
        
        }         
        return $this->render('KioskQuestionAnswerBundle:End:end.html.twig', array(
            "form" => $form->createView(),
            
        ));         
    }
    
}
