<?php

class RequestsController extends CEmployeeController
{
	public function actionIndex()
	{
		$daterange = Filter::StringDaterange([date('Y-m-01'),date('Y-m-31')]);

		$this->title = 'Заявки';
		$this->render('index', ['daterange'=>$daterange]);
	}

	public function actionAdd()
	{
		$this->title = 'Добавить заявку';
		if (Yii::app()->request->isPostRequest)
		{
			$request = new Request;
			$request->attributes = $_POST['request'];

			$to = U::gp('destinaion');
			$s = Station::findOne(['name'=>$to]);
            if (!$s) die('Нет такой станции');
            $request->id_destination = $s->id;

			if ($request->save())
				$this->redirect('/employee/requests');
			else
				var_dump($request->getErrors());
		}
		$this->render('add');
	}

	public function actionAjax()
	{
		list($rs, $n, $count) = DatatableHelper::GetRecords('Request', ['id']);

		$res = [];
		foreach ($rs as $r)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $r->id;
			$tmp['date'] = date('d.m.Y H:i', strtotime($r->create_date));
			$tmp['destination'] = $r->destination->name;
			$tmp['status'] = $r->getStatus();
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionView($id)
	{
		$r = Request::findOne(intval($id));
		if (!$r) $this->redirect('/employee/requests');


		if ($r->status == 'new') {
			if (Yii::app()->request->isPostRequest) {
				$r->attributes = $_POST['request'];
				if ($r->weight && $r->place_count && $r->id_storage)
					$r->status = 'storage';
				if ($r->save())
					$this->redirect('/employee/requests');
			}

			$this->title = 'Внесение фактических данных';
			$this->render('real_data', ['request'=>$r]);
		}
		else {
			$this->title = 'Просмотр заявки';
			$this->render('view', ['request'=>$r]);
		}
	}

	public function actionPrintReceipt($id)
	{
		$r = Request::findOne(intval($id));
		if (!$r) $this->redirect('/employee/requests');
		$this->renderPartial('printReceipt', ['request'=>$r]);
	}

	public function actionPrintRoadList($id)
	{
		$r = Request::findOne(intval($id));
		if (!$r) $this->redirect('/employee/requests');
		$this->renderPartial('printRoadList', ['request'=>$r]);
	}

	public function actionPrintRoadListSpine($id)
	{
		$r = Request::findOne(intval($id));
		if (!$r) $this->redirect('/employee/requests');
		$this->renderPartial('printRoadListSpine', ['request'=>$r]);
	}
}