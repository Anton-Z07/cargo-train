<?php

class CargoType extends ActiveRecord
{
	public function tableName()
	{
		return 'cargo_type';
	}

	public function rules()
	{
		return array(
			array('code, name', 'required'),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>1000),
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

	public static function getCode($name)
	{
		$item = self::findOne(['name'=>$name]);
		return $item ? $item->code : '';
	}
}
