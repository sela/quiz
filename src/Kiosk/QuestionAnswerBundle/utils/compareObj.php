<?php

namespace Kiosk\QuestionAnswerBundle\utils;

class compareObj {

    
    static public function compare($formObj)
    {
        if ($formObj->isEmpty()) return false;
        $correct = true;
        foreach ($formObj as $itemForm) {
            $correct &= $itemForm->getCorrect();
        }    
        return $correct;
    }
    
    static public function validate($formObj,$formDb,$correctAnswers)
    {
        if (count($formObj) == $correctAnswers) return true;
        else return false;
    }    
    
}
