<?php

class Filter
{
	public static function Daterange($default=false)
	{
		$s = Yii::app()->request->getParam('f_daterange');
		$a = explode(' - ', $s);
		if (count($a) != 2)
		{
			if ($default && count($default) == 2)
				return $default;
			return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')];
		}
		return [date('Y-m-d 00:00:00', strtotime($a[0])), date('Y-m-d 23:59:59', strtotime($a[1]))];
	}

	public static function GetVal($field)
	{
		return Yii::app()->request->getParam('f_'. $field, '');
	}

	public static function DaterangeToString($dr)
	{
		return date('d.m.Y', strtotime($dr[0])) . ' - ' . date('d.m.Y', strtotime($dr[1]));
	}

	public static function StringDaterange($default=false)
	{
		return self::DaterangeToString( self::Daterange($default) );
	}
}