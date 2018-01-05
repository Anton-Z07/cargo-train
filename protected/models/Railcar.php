<?php

class Railcar extends ActiveRecord
{
	public function tableName()
	{
		return 'railcar';
	}

	public function rules()
	{
		return array(
			array('number', 'required'),
			array('id_shipping, capacity', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>10),
			array('status', 'length', 'max'=>20),
			array('type', 'length', 'max'=>30),
			array('volume', 'numerical'),
		);
	}

	public function relations()
	{
		return array(
			'shipping'=>array(self::BELONGS_TO, 'Shipping', 'id_shipping'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatus()
	{
		$statuses = ['free'=>'Свободен', 'loaded'=>'Загружен'];
		return $statuses[$this->status];
	}

	public function setShipping($shipping)
	{
		$this->id_shipping = $shipping->id;
		$this->status = 'loaded';
		$this->update(['id_shipping', 'status']);
	}

	public function getRequests()
	{
		return Request::findMany(['id_shipping'=>$this->id_shipping]);
	}

	public function getTypeShort()
	{
		if (mb_strlen($this->type) > 6)
			return mb_substr($this->type, 0, 5) . '.';
		return $this->type;
	}
}
