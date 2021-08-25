<?php
namespace app\entities;

class NoReplyEntity
{
    protected $_from;

    public function __construct($from)
    {
        $this->_from = $from;
    }

    public function getFrom()
    {
        return $this->_from;
    }
}