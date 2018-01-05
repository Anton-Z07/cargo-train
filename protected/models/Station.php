<?php

class Station extends ActiveRecord
{
	public function tableName()
	{
		return 'station';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>100),
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

	public static function add($names)
	{
		$q = new CDbCriteria;
		$q->addInCondition('name', $names);
		$exist = [];
		foreach (self::findMany($q) as $s)
			$exist[] = $s->name;
		foreach ($names as $name)
		{
			if (in_array($name, $exist)) continue;
			$station = new self;
			$station->name = $name;
			$station->save();
		}
	}
}
