<?php

class Shipping extends ActiveRecord
{
	public function tableName()
	{
		return 'shipping';
	}

	public function rules()
	{
		return array(
			array('date, id_route, id_railcar', 'required'),
			array('id_route, id_railcar', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'route'=>array(self::BELONGS_TO, 'Route', 'id_route'),
			'railcar'=>array(self::BELONGS_TO, 'Railcar', 'id_railcar'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
