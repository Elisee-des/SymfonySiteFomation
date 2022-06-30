<?php
/*
This call sends a message based on a template.
*/
require 'vendor/autoload.php';

use Mailjet\Client;
use \Mailjet\Resources;

class Mail
{
    private $api_key = "c0d9f349bae53af4eca67c95b6d1e598";
    private $api_key_private = "3de5451f26c6aa9c5c379b3f1d76b350";

    public function send($mailTo, $nom,  $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_private, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "yentemasabidani@gmail.com",
                        'Name' => "Yentema"
                    ],
                    'To' => [
                        [
                            'Email' => $mailTo,
                            'Name' => $nom
                        ]
                    ],
                    'TemplateID' => 4046102,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'context' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
