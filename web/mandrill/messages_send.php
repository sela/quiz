<?php

/**
 * This examples shows how Mandrill library is used to send a message.
 */

require('Mandrill.php');
require('config.php');


class MessageSender {
    private $recipientEmail;
    private $recipientName;
    private $template;
    private $paramName;
    private $paramValue;
    
    private $data = '{"type":"messages",
        "call":"send-template",
        "template_name":"test-1",
        "template_content":[{
            "name": "header",
            "content": "Your Order is Complete"
         }],
        "message":{
          "html": "<h1>example html</h1>", 
          "text": "example text", 
          "subject": "example subject", 
          "from_email": "sela@sela-v.com", 
          "from_name": "sela", 
          "to":[{
              "email": "sela.yair@yahoo.com", 
              "name": "Wes Widner"
          }],
        "headers":{"...": "..."},
        "track_opens":true,
        "track_clicks":true,
        "auto_text":true,
        "url_strip_qs":true,
        "tags":["test","example","sample"],
        "google_analytics_domains":["sela-v.com"],
        "google_analytics_campaign":["..."],
        "metadata":["..."]}}';

    public function setRecipient($email,$name) {
        $this->recipientEmail = $email;
        $this->recipientName = $name;
        return $this;
    }
    
    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }
    
    public function prepareJSON() {
        if (!isset($this->recipientEmail))
            throw new ErrorException;    
        if (!isset($this->template))
            throw new ErrorException;          
        $this->dataJSON = json_decode($this->data);
        $this->dataJSON->message->to[0]->email = $this->recipientEmail;
        $this->dataJSON->template_name = $this->template;
    }

    public function deliver()
    {

        $this->prepareJSON();
//        var_dump($this->dataJSON);
//        die();
        $ret = Mandrill::call((array) $this->dataJSON);
        return $ret;
    }
    
}


$message = new MessageSender();
$message->setRecipient('Sela', 'sela.yair@yahoo.com')->setTemplate('test-1');
$ret = $message->deliver();
print_r($ret);