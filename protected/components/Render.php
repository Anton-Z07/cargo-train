<?php

class Render
{
	public static function SelectOptions($class, $selected=null)
	{
		foreach ($class::model()->findAll() as $item)
			echo "<option value='$item->id' ".($selected==$item->id?"selected='selected'":'').">$item->name</option>";
	}

	public static function SelectOptionsName($class, $selected=null)
	{
		foreach ($class::model()->findAll() as $item)
			echo "<option value='$item->id' ".($selected==$item->name?"selected='selected'":'').">$item->name</option>";
	}

	public static function SelectOptionsFromArray($options, $selected=null)
	{
		foreach ($options as $val => $name)
			echo "<option value='$val'".($selected==$val?"selected='selected'":'').">$name</option>";
	}

	public static function SelectOptionsFromArrayV($options, $selected=null)
	{
		foreach ($options as $name)
			echo "<option value='$name'".($selected==$name?"selected='selected'":'').">$name</option>";
	}
}