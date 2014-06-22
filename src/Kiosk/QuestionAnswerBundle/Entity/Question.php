<?php

namespace Kiosk\QuestionAnswerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kiosk\QuestionAnswerBundle\Entity\Answer;
use Kiosk\QuizBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/** @todo importance of the question
 * 
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
class Question extends EntityRepository {
    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    protected $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    
    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="questions")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;
    
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $question_text;

    /**
     * @ORM\ManyToOne(targetEntity="Kiosk\QuizBundle\Entity\Quiz", inversedBy="questions")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    protected $quiz;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rank;


//    public function findAllOrderedByName()
//    {
//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT id FROM KioskQuestionAnswerBundle:Question q'
//            )
//            ->getResult();        
//    }
    
    public function getCorrectAnswersArray()
    {
        $answers_text = array();
        foreach ($this->answers as $answer) {
            
            if ($answer->getCorrect() === true) {
                array_push($answers_text, $answer->getAnswerText());
            }
        }
        return $answers_text;
    }
    

    public function getAnswersArray()
    {
        $answers_text = array();
        foreach ($this->answers as $answer) {
            array_push($answers_text, $answer->getAnswerText());
        }
        return $answers_text;
    }
    
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
     * Set question_text
     *
     * @param string $questionText
     * @return Question
     */
    public function setQuestionText($questionText)
    {
        $this->question_text = $questionText;
    
        return $this;
    }

    /**
     * Get question_text
     *
     * @return string 
     */
    public function getQuestionText()
    {
        return $this->question_text;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Question
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set quiz
     *
     * @param Quiz $quiz
     * @return Question
     */
    public function setQuiz(Quiz $quiz = null)
    {
        $this->quiz = $quiz;
    
        return $this;
    }

    /**
     * Get quiz
     *
     * @return Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Add answers
     *
     * @param Answer $answers
     * @return Question
     */
    public function addAnswer(Answer $answers)
    {
        $this->answers[] = $answers;
    
        return $this;
    }

    /**
     * Remove answers
     *
     * @param Answer $answers
     */
    public function removeAnswer(Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function countCorrectAnswers()
    {
        $counter = 0;
        foreach ($this->answers as $item) {
            $counter = $item->getCorrect() ? $counter+1 : $counter;
        }
        return $counter;
    }
    
    

    /**
     * Set image
     *
     * @param \Kiosk\QuestionAnswerBundle\Entity\Image $image
     * @return Question
     */
    public function setImage(\Kiosk\QuestionAnswerBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \Kiosk\QuestionAnswerBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}