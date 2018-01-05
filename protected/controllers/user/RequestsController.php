<?php

class RequestsController extends CUserController
{
    public $layout = 'front';
    
	public function actionIndex()
	{
        $requests = Request::findMany(['id_user'=>Yii::app()->user->innerId]);
		$this->render('index', ['requests'=>$requests]);
	}

    public function actionCreate()
    {
        $from = U::gp('from');
        $to = U::gp('to');
        $r_id = U::gp('r_id');
        $date = U::gp('date');
        $route = Route::findById($r_id);
        if (!$from || !$to || !$r_id || !$date || !$route)
            $this->redirect('/user');
        if (Yii::app()->request->isPostRequest)
        {
            $request = new Request;
            $request->attributes = $_POST['request'];
            $request->id_user = Yii::app()->user->innerId;
            $s = Station::findOne(['name'=>$to]);
            if (!$s) die('Нет такой станции');
            $request->id_destination = $s->id;
            if ($request->save())
                $this->redirect('/user/requests');
        }
        
        $this->render('create', ['from'=>$from,'to'=>$to,'date'=>U::rd($date), 'route'=>$route]);
    }
}