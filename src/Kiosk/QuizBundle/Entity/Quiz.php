<?php

namespace Kiosk\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kiosk\QuestionAnswerBundle\Entity\Answer;
use Kiosk\QuestionAnswerBundle\Entity\Question;

/**
 * @ORM\Entity
 * @ORM\Table(name="quiz")
 */
class Quiz {
    /**
     * @ORM\OneToMany(targetEntity="Kiosk\QuestionAnswerBundle\Entity\Question", mappedBy="quiz")
     */
    protected $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;


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
     * @return Quiz
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
     * Add questions
     *
     * @param Question $questions
     * @return Quiz
     */
    public function addQuestion(Question $questions)
    {
        $this->questions[] = $questions;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param Question $questions
     */
    public function removeQuestion(Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}