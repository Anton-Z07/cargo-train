<?php

class Employee extends ActiveRecord
{
	public function tableName()
	{
		return 'employee';
	}

	public function rules()
	{
		return array(
			array('name, login, password', 'required'),
			array('name, login, password', 'length', 'max'=>60),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
