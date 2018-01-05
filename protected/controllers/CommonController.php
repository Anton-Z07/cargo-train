<?php

class CommonController extends Controller
{
	public function actionCalcPrice($id=false)
	{
		if ($id)
			$r = Request::findById($id);
		else {
			$r = new Request;
			$r->attributes = $_POST['request'];
		}
		if (!$r->weight) {
			$r->weight = $r->declared_weight;
			$r->volume = $r->declared_volume;
		}
		if (!$r->weight || !$r->volume)
			die('Недостаточно данных');
		$this->render('calc_price', ['r'=>$r]);
	}
}