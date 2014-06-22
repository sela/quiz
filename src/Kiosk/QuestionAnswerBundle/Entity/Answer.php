<?php

namespace Kiosk\QuestionAnswerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kiosk\QuestionAnswerBundle\Entity\Question;

/**
 * @ORM\Entity
 * @ORM\Table(name="answer")
 */
class Answer {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function __toString()
    {
        return $this->answer_text;
    }

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $answer_text;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $answer_text_short;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $correct;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Question
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set answer_text
     *
     * @param string $answerText
     * @return Answer
     */
    public function setAnswerText($answerText)
    {
        $this->answer_text = $answerText;
    
        return $this;
    }

    /**
     * Get answer_text
     *
     * @return string 
     */
    public function getAnswerText()
    {
        return $this->answer_text;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     * @return Answer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    
        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean 
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set question
     *
     * @param \Kiosk\QuestionAnswerBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Kiosk\QuestionAnswerBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer_text_short
     *
     * @param string $answerTextShort
     * @return Answer
     */
    public function setAnswerTextShort($answerTextShort)
    {
        $this->answer_text_short = $answerTextShort;
    
        return $this;
    }

    /**
     * Get answer_text_short
     *
     * @return string 
     */
    public function getAnswerTextShort()
    {
        return $this->answer_text_short;
    }
}