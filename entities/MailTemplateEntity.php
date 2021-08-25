<?php
namespace app\entities;

class MailTemplateEntity
{
    const TEMPLATE_CONTACT = 'contact';

    const TEMPLATE_NOTIFY  = 'notify';

    public function getContactTemplate()
    {
        return $this->getCombined(static::TEMPLATE_CONTACT);
    }

    public function getNotifyTemplate()
    {
        return $this->getCombined(static::TEMPLATE_NOTIFY);
    }

    public function getCombined($name)
    {
        return [
            'html' => ($name.'-html'),
            'text' => ($name.'-text')
        ];
    }
}