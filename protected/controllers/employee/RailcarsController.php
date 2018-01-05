<?php

class RailcarsController extends CEmployeeController
{
	public function actionIndex()
	{
		$this->title = 'Вагоны';
		$this->render('index');
	}

	public function actionAdd($id=false)
	{
		$railcar = false;
		if ($id) $railcar = Railcar::findById($id);
		$this->title = 'Добавить вагон';
		if ($railcar) $this->title = 'Редактировать вагон';
		if (!$railcar) $railcar = new Railcar;
		if (Yii::app()->request->isPostRequest)
		{
			$railcar->attributes = $_POST['railcar'];
			if ($railcar->save())
				$this->redirect('/employee/railcars');
			var_dump($railcar->getErrors());
		}
		$this->render('add', ['railcar'=>$railcar]);
	}

	public function actionAjax()
	{
		list($rs, $n, $count) = DatatableHelper::GetRecords('Railcar');

		$res = [];
		foreach ($rs as $r)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $r->id;
			$tmp['number'] = $r->number;
			$tmp['status'] = $r->getStatus();
			$tmp['route'] = $r->id_shipping ? $r->shipping->route->name : '';
			$tmp['actions'] = ($r->status == 'free' ? 'load' : '');
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionView($id)
	{
		$railcar = Railcar::findOne(intval($id));
		if (!$railcar) $this->redirect('/employee/railcars');

		$this->title = 'Просмотр вагона №' . $railcar->number;
		$this->render('view', ['railcar'=>$railcar]);
	}

	public function actionLoad($id)
	{
		$railcar = Railcar::findOne(intval($id));
		if (!$railcar) $this->redirect('/employee/railcars');

		$this->title = 'Загрузка вагона №' . $railcar->number;
		if (U::gp('id_route'))
		{
			$route = Route::findById(U::gp('id_route'));
			if (Yii::app()->request->isPostRequest) {
				$shipping = new Shipping;
				$shipping->date = date('Y-m-d', strtotime(U::gp('date')));
				$shipping->id_route = $route->id;
				$shipping->id_railcar = $railcar->id;
				$shipping->conductor1 = U::gp('conductor1');
				$shipping->conductor2 = U::gp('conductor2');
				if ($shipping->save()) {
					$ids = json_decode(U::gp('requests'), 1);
					foreach ($ids as $id) {
						$r = Request::findById($id);
						$r->setShipping($shipping);
					}
					$railcar->setShipping($shipping);
					$this->redirect('/employee/railcars');
				}
			}
			list($to_load, $spare) = $route->getRequests($railcar);
			$this->render('load2', ['railcar'=>$railcar, 'to_load'=>$to_load, 'spare'=>$spare]);
		}
		else
			$this->render('load', ['railcar'=>$railcar]);
	}

	public function actionPrint($id)
	{
		$this->render('print');
	}
}