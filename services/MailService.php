<?php
namespace app\services;

use yii\mail\MailerInterface;

class MailService
{
    protected $_mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->_mailer = $mailer;
    }

    public function sendMail($template, $from, $to, $subject, $data = [])
    {
        return $this->_mailer
        ->compose($template,['data' => $data])
        ->setFrom($from)
        ->setTo($to)
        ->setSubject($subject)
        ->send();
    }
}