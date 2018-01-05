<?php

class HomeController extends CUserController
{
	public function actionIndex()
	{
		$this->redirect('/user/requests');
	}
}