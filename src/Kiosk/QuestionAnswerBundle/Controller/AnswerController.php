<?php
/**
 * Created by PhpStorm.
 * User: selayair
 * Date: 04/10/2013
 * Time: 14:30
 */

namespace Kiosk\QuestionAnswerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Kiosk\QuestionAnswerBundle\Entity\Learn;
use Kiosk\QuestionAnswerBundle\utils\zmq;


class AnswerController extends Controller {

    
    /**
     * display correct answer
     * @Route("/correct", name="answer_correct")
     */
    public function correctAction(Request $request)
    {
        $session = $request->getSession();
        $question_id = $session->get('question_counter');          
        $learn = new Learn();
        $form = $this->createFormBuilder($learn)
        ->add('Next', 'submit') 
        ->getForm();  
        $form->handleRequest($request); 
        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('question_next'));                
        }
        zmq::send('Your answer is correct', '', $session->get('bg_image'));
        
        return $this->render('KioskQuestionAnswerBundle:Answer:keyboard.html.twig', array(
            "id" => $question_id, 
            "form" => $form->createView(),
        ));        
        
    }    
    
    
    /**
     * display incorrect answer
     * @Route("/incorrect", name="answer_incorrect")
     */
    public function incorrectAction(Request $request)
    {
        $session = $request->getSession();
        $question_id = $session->get('question_counter');          
        $learn = new Learn();
        $form = $this->createFormBuilder($learn)
        ->add('Answer', 'submit') 
        ->add('Next', 'submit') 
        ->add('Main', 'submit') 
        ->getForm();  
        $form->handleRequest($request); 
        if ($form->isValid()) {
            if ($form->get('Answer')->isClicked()) {
                return $this->redirect($this->generateUrl('learn')); 
            }
            if ($form->get('Main')->isClicked()) {
                return $this->redirect($this->generateUrl('start'));                    
            }            
            return $this->redirect($this->generateUrl('question_next'));                
        }
        zmq::send('Your answer is incorrect, select Answer if you want to find the correct Answer', '', $session->get('bg_image'));
        
        return $this->render('KioskQuestionAnswerBundle:Answer:keyboard.html.twig', array(
            "id" => $question_id, 
            "form" => $form->createView(),
        ));        
        
    }      
    
    
    /**
     * explain the correct answer
     * @Route("/learn", name="learn")
     */
    public function learnAction(Request $request)
    {
        $session = $request->getSession();
        $question_id = $session->get('question_counter');  
        $question_number = $session->get('question_numbers');
        $question_number = $question_number[$question_id];
        
        $question = $this->getDoctrine()
            ->getRepository('KioskQuestionAnswerBundle:Question')
            ->find($question_number);   

        $arr = $question->getCorrectAnswersArray();
       
        $empty = null;
        $form = $this->createFormBuilder($empty)
        ->add('Next', 'submit') 
        ->getForm();  
        $form->handleRequest($request); 
        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('question_next'));                
        }
        zmq::send('The correct answer(s): '.implode(', ', $arr), '', $session->get('bg_image'));
        
        return $this->render('KioskQuestionAnswerBundle:Answer:keyboard.html.twig', array(
            "id" => $question_id, 
            "form" => $form->createView(),
        ));        
        
    }     
    
    /**
     * @Route("/verify", name="verify_answer")
     */
    public function verifyAction(Request $request)
    {
        
        $session = $request->getSession();
        $question_id = $session->get('question_counter');  
        $question = $this->getDoctrine()
            ->getRepository('KioskQuestionAnswerBundle:Question')
            ->find($question_id);
        $answers = $question->getAnswers();
        foreach($answers as $answer) {
            var_dump($answer->getCorrect());
        }
        
        die();

//        if ($this->getRequest()->isMethod('POST')) {
// push the question to the primary screen
        zmq::send('verify', $answers, $session->get('bg_image'));
        
        return $this->render('KioskQuestionAnswerBundle:Answer:keyboard_bak.html.twig', array(
            "id" => $id+1, 
        ));
        
        return $this->redirect($this->generateUrl('answer_show',array("id" => $id+1)),301);

//        }

    }
    

    /**
     * @Route("/keyboard/{id}", requirements={"id" = "\d+"}, name="answer_show_old")
     */
    public function keyboardAction($id)
    {
        $session = $this->get('session');
        if (!$session->has('quizId')) {
//            return $this->forward('KioskQuestionBundle:Answer:verifyAction',
//                    array('id' => '0'));
            return $this->redirect($this->generateUrl('verify_answer',array("id" => '0')));
        }
        $answers = $this->getDoctrine()
            ->getRepository('KioskQuestionAnswerBundle:Answer')
            ->findBy(array('question' => $id));

        
        
        if (!$answers) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
       
        $session->set('quizId', '1');
        return $this->render(
            'KioskQuestionAnswerBundle:Answer:keyboard.html.twig',
            array('answers' => $answers, 'id' => $id)
        );

    }


    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        zmq::send('testing the machine', null);
        


    }    
    
    
} 