<?php
/**
 * Created by PhpStorm.
 * User: selayair
 * Date: 04/10/2013
 * Time: 14:30
 */

namespace Kiosk\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class AnswerController extends Controller {


    /**
     * @Route("/keyboard/{id}", requirements={"id" = "\d+"}, name="answer_show")
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
            ->getRepository('KioskQuestionBundle:Answer')
            ->findBy(array('question' => $id));

        
        
        if (!$answers) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
       
        $session->set('quizId', '1');
        return $this->render(
            'KioskQuestionBundle:Answer:keyboard.html.twig',
            array('answers' => $answers, 'id' => $id)
        );

    }

    /**
     * @Route("/verify/{id}", name="verify_answer")
     */
    public function verifyAction($id)
    {
// retrieve the next question
        $question = $this->getDoctrine()
            ->getRepository('KioskQuestionBundle:Question')
            ->find($id+1);
        $answers = $question->getAnswers();
//        foreach($answers as $answer) {
//            var_dump($answer->getCorrect());
//        }
        
        //die();

//        if ($this->getRequest()->isMethod('POST')) {
// push the question to the primary screen
        $entryData = array(
          'cat'     => 'kittensCategory'
        , 'title'   => $question->getQuestionText()
        , 'answers' => $answers        
        , 'article' => 'article'
        , 'when'    => time()
        );

        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode($entryData));
        
        return $this->render('KioskQuestionBundle:Answer:keyboard.html.twig', array(
            "id" => $id+1, "answers" => $answers
        ));
        
        return $this->redirect($this->generateUrl('answer_show',array("id" => $id+1)),301);

  //      }

    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
// retrieve the next question
//        $question = $this->getDoctrine()
//            ->getRepository('KioskQuestionBundle:Question')
//            ->find($id+1);
//
//        $answers = $question->getAnswers();
//        foreach($answers as $answer) {
////            var_dump($answer->getCorrect());
//        }

//        if ($this->getRequest()->isMethod('POST')) {
// push the question to the primary screen
        $entryData = array(
          'cat'     => 'kittensCategory'
        , 'title'   => 'testing the machine'
        , 'article' => 'article'
        , 'when'    => time()
        );

        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode($entryData));
        return \Symfony\Component\HttpFoundation\Response::create('test');
//        return $this->redirect($this->generateUrl('answer_show',array("id" => $id+1)),301);

  //      }

    }    
    
    
} 