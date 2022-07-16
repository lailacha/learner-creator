<?php

namespace App\Core;

use \App\Model\ReceivePassword as ReceivePasswordMananger;

class ReceivePassword
{
    private $email;
    private $idUser;
    private $token;


    public function __construct()
    {

    }

    public function sendPasswordResetEmail(ReceivePasswordMananger $receivePassword)
    {

        $this->email = $receivePassword->getEmail();
        $this->idUser = $receivePassword->getIdUser();
        $this->token = $receivePassword->getToken();

        $html = '<a href="http://learner-creator.online/changePassword?token=' . $this->token . '&mail=' . $this->email . '&id=' . $this->idUser .'"><h2>Click here to change your password!</h2></a>';
        $confirmMail = new Mail();
        $confirmMail->setSubject("Last step to change your password...");
        $confirmMail->setContent($html);
        $confirmMail->setApiKey(MAILJET_API_KEY);
        $confirmMail->setReceiver($this->email);
        $confirmMail->setReceiverName($this->email);
        $confirmMail->sendMail();

    }
}