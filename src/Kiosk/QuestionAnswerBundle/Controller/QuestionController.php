<?php

namespace Kiosk\QuestionAnswerBundle\Controller;

use Kiosk\QuestionAnswerBundle\Entity\Question;
use Kiosk\QuestionAnswerBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Kiosk\QuestionAnswerBundle\utils\zmq;

class QuestionController extends Controller {

    private $questions_number;


    /**
     * entry point to the quiz
     * @Route("/start", name="start")
     * @todo update session question_counter according to the first question in 
     * the database
     */
    public function startAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ids = $em->getRepository('KioskQuestionAnswerBundle:Question')->findAll();
        $img = $em->getRepository('KioskQuestionAnswerBundle:Image')->find(1);
        
        $arr_keys = array();
        foreach ($ids as $value) {
            array_push($arr_keys, $value->getId());
        }
        $this->questions_number = array();
        foreach( array_rand($arr_keys, 10) as $k ) {
          $this->questions_number[] = $arr_keys[$k];
        }    

        $session = $request->getSession();
        $session->set('question_numbers', $this->questions_number);
//        $session->set('question_number', $this->questions_number[0]);
        $session->set('question_counter', 0);
        $session->set('correct_answers',0);                
        $session->set('incorrect_answers',0);          
        $empty = null;
        $form = $this->createFormBuilder($empty)
        ->add('Next', 'submit') 
        ->getForm();   

        $form->handleRequest($request); 
        
        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('question_show'));
        
        } 
//        $image = '/Users/selayair/NetBeansProjects/quiz/src/Kiosk/QuestionAnswerBundle/Resources/public/img/britian/Cocoa-1874-110.jpg';
        
        zmq::send('This quiz consist a set of 10 questions with multi choice answers. Your score will be revealed when you complete the quiz.', '',$img->getPath());
        
        return $this->render('KioskQuestionAnswerBundle:Question:instruction.html.twig', array(
            "form" => $form->createView(),
            
        ));        
    }
    
    /**
     * redirect to the next question
     * @Route("/next", name="question_next")
     */
    public function nextAction(Request $request)
    {
        $session = $request->getSession();
        if ((sizeof($session->get('question_numbers'))-1) > $session->get('question_counter')) {
            $question_id = $session->get('question_numbers');    
            $question_id = $question_id[$session->get('question_counter')];
        }
        else {
            return $this->redirect($this->generateUrl('end'));                
        }
        $session->set('question_counter', $session->get('question_counter')+1);    
        return $this->redirect($this->generateUrl('question_show'));
    }    
    
    
    /**
     * ask the question and verify
     * @Route("/question", name="question_show")
     */
    public function showAction(Request $request)
    {
        $session = $request->getSession();
        $question_id = $session->get('question_numbers');    
        $question_id = $question_id[$session->get('question_counter')];
        $question = $this->getDoctrine()
            ->getRepository('KioskQuestionAnswerBundle:Question')
            ->find($question_id);
        if ($question) {
            $answers = $question->getAnswers();
            $correctAnswers =  $question->countCorrectAnswers();
        }
        else {
            return $this->redirect($this->generateUrl('end'));    
        }
        $answer = new Answer();
        $form = $this->createFormBuilder($answer)
        ->add('AnswerText', 'entity', array(
            'class' => 'KioskQuestionAnswerBundle:Answer',
            'choices' => $question->getAnswers(),
            'expanded' => true,
            'multiple' => true,
        ))
        ->add('Submit', 'submit') 
        ->add('Main', 'submit')                 
        ->getForm();   
        $form->handleRequest($request); 
        
        if ($form->isValid()) {
            if ($form->get('Main')->isClicked()) {
                return $this->redirect($this->generateUrl('start'));    
            
            }
            $data = $form->get('AnswerText')->getData();
            $result_correct = \Kiosk\QuestionAnswerBundle\utils\compareObj::compare($data);
            $ret = \Kiosk\QuestionAnswerBundle\utils\compareObj::validate($data,$answers,$correctAnswers); 
            $result_correct = $result_correct & $ret;
            if ($result_correct) {
                $result = $session->get('correct_answers');
                $session->set('correct_answers', $result+1);
                return $this->redirect($this->generateUrl('answer_correct'));    
            }
            else {
                $result = $session->get('incorrect_answers');
                $session->set('incorrect_answers', $result+1);                
                return $this->redirect($this->generateUrl('answer_incorrect'));  
            }
        }        
        $answers_text = $question->getAnswersArray();
        
       
        $image = $question->getImage()->getPath(); 
        $session->set('bg_image', $image);                

        zmq::send($question->getQuestionText(), $answers_text, $image ); //$question->getAnswersText());
        return $this->render('KioskQuestionAnswerBundle:Question:keyboard.html.twig', array(
            "id" => $session->get('question_counter'), 
            "form" => $form->createView(),
            "answers" => $answers,
            "correct" => $correctAnswers,
        ));
    }    
    
    
    
} 