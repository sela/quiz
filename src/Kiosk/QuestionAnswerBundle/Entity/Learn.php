<?php

namespace Kiosk\QuestionAnswerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Learn
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Learn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}