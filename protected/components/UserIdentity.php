<?php

class UserIdentity extends CUserIdentity
{
	public function authenticate($verify=true, $prev_id=false)
	{
		$this->errorCode=self::ERROR_USERNAME_INVALID;
		$correct = false;
		$user = false;

		$user = User::model()->findByAttributes(array('email'=>$this->username));
		if($user && (!$verify || CPasswordHelper::verifyPassword($this->password, $user->password)))
		{
			$correct = true;
			$this->setState('type', 'user');
		}

		if(!$user)
		{
			$user = Employee::model()->findByAttributes(array('login'=>$this->username));
			if($user &&  (!$verify || CPasswordHelper::verifyPassword($this->password, $user->password)))
			{
				$correct = true;
				$this->setState('type', 'employee');
			}
		}

		if ($correct)
		{
			$this->errorCode=self::ERROR_NONE;
			$this->setState('innerId', $user->id);
			$this->setState('name', $user->getName());
			if ($prev_id !== false)
				$this->setState('prev_id', $prev_id);
		}

		return !$this->errorCode;
	}
}