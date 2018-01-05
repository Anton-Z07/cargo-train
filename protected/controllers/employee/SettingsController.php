<?php

class SettingsController extends CEmployeeController
{
	public function init()
	{
		$this->title = 'Настройки';
		$this->breadcrumbs[] = array('name' => $this->title);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSave()
	{
		$settings = $_POST['settings'];
		foreach ($settings as $name=>$setting)
			Settings::SetEncoded($name, $setting);
		$this->redirect('/employee/settings');
	}
}