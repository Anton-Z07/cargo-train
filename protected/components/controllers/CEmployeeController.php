<?php

class CEmployeeController extends Controller
{
    public $breadcrumbs = array(array('name' => 'Главная', 'url' => '/employee'));
    public $layout = 'employee';
    
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
                'expression'=>'$user->isGuest || $user->type !== "employee"',
            ),
        );
    }
}