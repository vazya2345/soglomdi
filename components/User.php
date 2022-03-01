<?php
namespace app\components;

use yii\web\User as UserBase;

class User extends UserBase
{
	public function getRole()
    {
        $identity = $this->getIdentity();

        return $identity !== null ? $identity->getRole() : null;
    }
}