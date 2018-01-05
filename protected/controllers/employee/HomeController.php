<?php

class HomeController extends CEmployeeController
{
	public function actionIndex()
	{
		$this->redirect('/employee/requests');
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
}