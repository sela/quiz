<?php

namespace Kiosk\QuestionAnswerBundle\utils;

class zmq {

    public static function send($title, $answers, $image)
    {
        $entryData = array(
          'cat'     => 'mainScreen'
        , 'title'   => $title // $question->getQuestionText()
        , 'answers' => $answers     
        , 'image' => $image       
        , 'article' => 'article'
        , 'when'    => time()
        );
        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode($entryData));
       
    }
    
}
