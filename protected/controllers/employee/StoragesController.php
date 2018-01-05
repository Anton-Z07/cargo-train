<?php

class StoragesController extends CEmployeeController
{
	public function actionIndex()
	{
		$this->title = 'Виртуальные склады';
		$this->render('index');
	}

	public function actionAdd($id=false)
	{
		$storage = false;
		if ($id) $storage = Storage::findById($id);
		if (!$storage) $storage = new Storage;
		$this->title = 'Добавить виртуальный склад';
		if (Yii::app()->request->isPostRequest)
		{
			$storage->attributes = $_POST['storage'];
			if ($storage->save())
				$this->redirect('/employee/storages');
			var_dump($storage->getErrors());
		}
		$this->render('add', ['storage'=>$storage]);
	}

	public function actionAjax()
	{
		list($rs, $n, $count) = DatatableHelper::GetRecords('Storage');

		$res = [];
		foreach ($rs as $r)
		{
			$tmp = [];
			$tmp['n'] = $n++;
			$tmp['id'] = $r->id;
			$tmp['name'] = $r->name;
			$tmp['destination'] = $r->destination->name;
			$tmp['is_default'] = $r->is_default ? 'Да' : '';
			$res[] = $tmp;
		}
		echo json_encode([
			'data'=>$res,
			'recordsTotal'=>$count,
			'recordsFiltered'=>$count]);
	}

	public function actionView($id)
	{
		$storage = Storage::findOne(intval($id));
		if (!$storage) $this->redirect('/employee/storages');

		$this->title = 'Просмотр склада ' . $storage->name;
		$this->render('view', ['storage'=>$storage]);
	}
}