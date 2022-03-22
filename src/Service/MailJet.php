<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class MailJet
{
    private $apiKey = '598aec769ce4a226f75ec25148ec542e';
    private $secretKey = '5feaf3c6ab846ed538b8755c72139280';

    public function send($recipientEmail, $recipientName, $subject, $title, $content, $button)
    {
        $mj = new Client($this->apiKey, $this->secretKey,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "dydream-decor@outlook.fr",
                        'Name' => "Dydream Decor"
                    ],
                    'To' => [
                        [
                            'Email' => $recipientEmail,
                            'Name' => $recipientName
                        ]
                    ],
                    'TemplateID' => 3760141,
                    'TemplateLanguage' => true,
                    'Subject' => "$subject",
                    'Variables' => [
                        'TemplateLanguage' => true,
                        'title' => "$title",
                        'content' => "$content",
                        'button' => "$button"
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}