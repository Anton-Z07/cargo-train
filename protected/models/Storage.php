<?php

class Storage extends ActiveRecord
{
	public function tableName()
	{
		return 'storage';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id_destination, is_default', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
		);
	}

	public function relations()
	{
		return array(
			'destination'=>array(self::BELONGS_TO, 'Station', 'id_destination'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRequests()
	{
		return Request::findMany(['id_storage'=>$this->id,'status'=>'storage']);
	}
}
