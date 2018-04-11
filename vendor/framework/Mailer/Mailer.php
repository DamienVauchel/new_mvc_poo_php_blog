<?php

namespace Framework\Mailer;

use Symfony\Component\Yaml\Yaml;

class Mailer
{
    private $to;

    public function __construct()
    {
        $config = Yaml::parseFile('app/config/mailer.yaml');
        $this->to = $config['mailer']['to'];
    }

    public function sendMail($lastname, $firstname, $email, $subject, $message)
    {
        $header = $firstname . " " . $name . " <" . $email . ">";

        mail($this->to, $subject, $message, 'From: ' . $header);
    }
}