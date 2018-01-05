<?php

class CriteriaHelper
{
	public static function SetDaterange($criteria)
	{
		list($from, $to) = Filter::Daterange();
		$criteria->addCondition("t.date>='$from' AND t.date<='$to'");
	}

	public static function SetFilter($criteria, $field)
	{
		$val = Filter::GetVal($field);
		if ($val)
			$criteria->compare($field, $val);
	}
}