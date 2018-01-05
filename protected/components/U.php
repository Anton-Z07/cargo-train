<?php

class U
{
	public static function gp($name, $default=null)
	{
		return Yii::app()->request->getParam($name, $default);
	}

	public static function gi($name, $default=0)
	{
		return intval(self::gp($name, $default));
	}

	public static function now()
	{
		return date('Y-m-d H:i:s');
	}

	public static function pd($n)
	{
		return str_pad( $n, 2, '0', STR_PAD_LEFT);
	}

	public static function rd($d)
	{
		return date('d.m.Y', strtotime($d));
	}
}