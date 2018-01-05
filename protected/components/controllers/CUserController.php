<?php

class CUserController extends Controller
{
    public $breadcrumbs = array(array('name' => 'Главная', 'url' => '/user'));
    public $layout = 'main';
    
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
            	'users'=>array('?')
            ),
            array('deny',
                'users'=>array('@'),
                'expression'=>'$user->isGuest || $user->type !== "user"',
            ),
        );
    }
}