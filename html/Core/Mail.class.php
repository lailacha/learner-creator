<?php


namespace App\Core;

use App\Core\View;


class Mail
{

    private $apiKey;
    private $content;
    private $receiver;
    private $receiverName;
    private $subject;

    /**
     * @param mixed $receiverName
     */
    public function setReceiverName($receiverName): void
    {
        $this->receiverName = $receiverName;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @param string $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey): void
    {
        $this->apiKey = $apiKey;
    }
    public function sendMail()
    {
        $mail = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => MAIL_SENDER,
                        'Name' => MAIL_SENDER_NAME,
                    ],
                    'To' => [
                        [
                            'Email' => $this->receiver,
                            'Name' => $this->receiverName,
                        ]
                    ],
                    'Subject' => $this->subject,
                    'HTMLPart' => $this->content,
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mail));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey);
        $server_output = curl_exec($ch);

        curl_close ($ch);

        return json_decode($server_output);
    }


}