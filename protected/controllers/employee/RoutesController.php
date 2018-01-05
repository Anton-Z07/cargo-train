<?php

class RoutesController extends CEmployeeController
{
	public function actionIndex()
	{
		$this->title = 'Маршруты';
		$this->render('index');
	}

	public function actionAdd($id=false)
	{
		$route = false;
		if ($id) $route = Route::findById($id);
		if (!$route) $route = new Route;
		$this->title = 'Добавить маршрут';
		if (Yii::app()->request->isPostRequest)
		{
			$route->attributes = $_POST['route'];
			if ($route->stations) {
				$stations = json_decode($route->stations);
				$names = [];
				foreach ($stations as $s)
					$names[] = $s->n;
				Station::add($names);
			}
			if ($route->save())
				$this->redirect('/employee/routes');
			var_dump($route->getErrors());
		}
		$this->render('add', ['route'=>$route]);
	}

	public function actionAjax()
	{
		list($rs, $n, $count) = DatatableHelper::GetRecords('Route');

		$res = [];
		foreach ($rs as $r)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $r->id;
			$tmp['name'] = $r->name;
			$tmp['number'] = $r->number;
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionView($id)
	{
		$route = route::findOne(intval($id));
		if (!$route) $this->redirect('/employee/routes');

		$this->title = 'Просмотр склада ' . $route->name;
		$this->render('view', ['route'=>$route]);
	}
}