<?php

class SiteController extends Controller
{
	public $layout = 'front';

	public function actionIndex()
	{
		$routes = $search = false;
		$from = U::gp('from', 'Москва');
		$to = U::gp('to');
		$weight = U::gi('weight');
		if ($from && $to) {
			$search = true;
			$routes = Route::search($from, $to);
		}
		$this->render('index', ['routes'=>$routes, 'weight'=>$weight, 'from'=>$from, 'to'=>$to, 'search'=>$search]);
	}

	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect('/site/redirect');
		if (Yii::app()->request->isPostRequest)
		{
			$user = new UserIdentity(U::gp('login'), U::gp('password'));
			if ($user->authenticate())
			{
				Yii::app()->user->login($user, 3600*24*7);
				$this->redirect('/site/redirect');
			}
		}
		$this->render('login');
	}

	public function actionRedirect()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect('/');
		if (Yii::app()->user->type == 'employee')
			$this->redirect('/employee');
		if (Yii::app()->user->type == 'user')
		{
			if ($url = Common::getRedirectUrl())
				$this->redirect($url);
			$this->redirect('/user');
		}
		$this->redirect('/site/logout');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			var_dump($error);
		}
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionStationsHint($q)
	{
        $result = [];
        $cr = new CDbCriteria;
        $cr->addSearchCondition('name', $q);
        $cr->limit = 10;
        $cr->select = ['name'];
        foreach (Station::findMany($cr) as $s)
        {
        	$result[] = $s->name;
        }
        echo json_encode($result);
	}

	public function actionCargoTypeHint($q)
    {
        $result = [];
        $cr = new CDbCriteria;
        $cr->addSearchCondition('name', $q);
        $cr->limit = 10;
        $cr->select = ['name'];
        foreach (CargoType::findMany($cr) as $s)
        {
            $result[] = $s->name;
        }
        echo json_encode($result);
    }

	public function actionRegister()
	{
		$redirect_url = '/user/requests/create?r_id='.U::gp('r_id').'&date='.U::gp('date').'&from='.U::gp('from').'&to='.U::gp('to').'&weight='.U::gp('weight');
		if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user')
			$this->redirect($redirect_url);
		Common::setRedirectUrl($redirect_url);
		$error = false;
		$email = filter_var(U::gp('login'), FILTER_VALIDATE_EMAIL);
		if (Yii::app()->request->isPostRequest && U::gp('login') && U::gp('password'))
		{
			if (!User::checkLogin(U::gp('login')))
				$error = 'Пользователь с таким логином уже существует';
			if (!$email)
				$error = 'Email имеет неправильный формат';
			if (!$error) {
				$user = new User;
				$user->email = U::gp('login');
				$user->password = CPasswordHelper::hashPassword(U::gp('password'));
				if ($user->save()) {
					$ui = new UserIdentity($email, U::gp('password'));
					var_dump($ui->authenticate());
					if ($ui->authenticate())
					{
						Yii::app()->user->login($ui, 3600*24*7);
						$this->redirect($redirect_url);
					}
				} else 
					$error = 'Не удалось создать пользователя';
			}
		}
		$this->render('register', ['error'=>$error]);
	}
}