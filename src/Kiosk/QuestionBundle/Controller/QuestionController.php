<?php
/**
 * Created by PhpStorm.
 * User: selayair
 * Date: 09/10/2013
 * Time: 12:53
 */

namespace Kiosk\QuestionBundle\Controller;

use Kiosk\QuestionBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;


class QuestionController extends Controller {

    /**
     * @Route("/question/{id}", requirements={"id" = "\d+"}, name="question_show")
     */
    public function newAction(Request $request)
    {
        $question = new Question();


        $form = $this->createFormBuilder($question)
//            ->add('answers', 'choice')
            ->add('questionText','text')
            ->add('Submit', 'submit')
            ->getForm();

        return $this->render('KioskQuestionBundle:Question:keyboard.html.twig', array(
            'form' => $form->createView(),
        ));
    }
} 