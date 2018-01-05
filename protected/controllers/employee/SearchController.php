<?php

class SearchController extends CEmployeeController
{
	public function actionIndex()
	{
		$routes = false;
		$weight = 0;
		$from = U::gp('from', 'Москва');
		$to = U::gp('to');
		$weight = U::gi('weight');
		if ($from && $to) $routes = Route::search($from, $to);
		
		$this->render('index', ['routes'=>$routes, 'weight'=>$weight, 'from'=>$from, 'to'=>$to]);
	}
}