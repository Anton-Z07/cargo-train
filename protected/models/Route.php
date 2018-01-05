<?php

class Route extends ActiveRecord
{
	public function tableName()
	{
		return 'route';
	}

	public function rules()
	{
		return array(
			array('name, number', 'required'),
			array('id_destination', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('speed', 'length', 'max'=>20),
			array('number', 'length', 'max'=>10),
			array('schedule, stations', 'safe'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getName()
	{
		return "№{$this->number}. $this->name";
	}

	public function getStorage()
	{
		$storage = Storage::findOne(['id_destination'=>$this->id_destination]);
		if (!$storage) $storage = Storage::findOne(['is_default'=>1]);
		return $storage;
	}

	public function getRequests($railcar)
	{
		$storage = $this->getStorage();
		$weight = 0;
		$volume = 0;
		$all_requests = $storage->getRequests();
		$to_load = $spare = [];
		foreach ($all_requests as $r) {
			if ($r->id_destination != $this->id_destination) continue;
			if ($weight + $r->weight > $railcar->capacity || $volume + $r->volume > $railcar->volume) 
				$spare[] = $r;
			else {
				$weight += $r->weight;
				$volume += $r->volume;
				$to_load[] = $r;
			}
		}
		foreach ($all_requests as $r) {
			if ($r->id_destination == $this->id_destination) continue;
			if ($weight + $r->weight > $railcar->capacity || $volume + $r->volume > $railcar->volume) 
				$spare[] = $r;
			else {
				$weight += $r->weight;
				$volume += $r->volume;
				$to_load[] = $r;
			}
		}
		return [$to_load, $spare];
	}

	public function getDates($today = false, $limit = 30)
	{
		if (!$this->schedule) return [];
		$res = [];
		$before = [];
		$after = [];
		if ($today) $today = date('m-d', strtotime($today));
		else $today = date('m-d');
		foreach (json_decode($this->schedule,1) as $month => $days) {
			foreach ($days as $day)
			{
				$d = U::pd( date_parse($month)['month'] ) . '-' .  U::pd($day);
				if ($d < $today)
					$before[] = (intval(date('Y')) + 1) . '-' . $d;
				else
					$after[] =  date('Y') . '-' . $d;
			}
		}
		$res = array_merge($after, $before);
		$res = array_slice($res, 0, $limit);
		return $res;
	}

	public function getStation($name, $date)
	{
		if (!$this->stations) return false;
		$stations = json_decode($this->stations);
		$t = strtotime($date);
		foreach ($stations as $s)
		{
			if ($s->p) $t += 86400;
			if ($s->n == $name) {
				if (isset($s->a)) $s->a = date('Y-m-d ', $t) . $s->a;
				if (isset($s->d)) $s->d = date('Y-m-d ', $t) . $s->d;
				return $s;
			}
		}
		return false;
	}

	public function getArrivalDate($station, $today = false)
	{
		if ($today) $today = date('Y-m-d', strtotime($today));
		else $today = date('Y-m-d');
		$s = $this->getStation($station, $today);
		if ($s) return $s->a;
	}

	public function getDepatrureDate($station, $today = false)
	{
		if ($today) $today = date('Y-m-d', strtotime($today));
		else $today = date('Y-m-d');
		$s = $this->getStation($station, $today);
		if ($s) return $s->d;
	}

	public function getInTravelTime($from, $to, $readable=false)
	{
		$f = $this->getStation($from, U::now());
		$t = $this->getStation($to, U::now());
		if (!$f || !$t) return '';
		$minutes = $t->t - $f->t;
		if ($readable) return Common::minutesToTime($minutes);
		else return $minutes;
	}

	public function getStandingTime($station, $readable=false)
	{
		$s = $this->getStation($station, U::now());
		if (!$s) return 0;
		if (!isset($s->s)) {
			if ($readable) return 'Конечная';
			else return -1;
		} else {
			if ($readable) return Common::minutesToTime($s->s);
			else return $s->s;
		}
	}

	public static function search($from=false, $to=false)
	{
		$res = [];
		$dates = [];
		$q = new CDbCriteria;
		if ($from) $q->addSearchCondition('stations', '"n":"'.$from.'"');
		if ($to) $q->addSearchCondition('stations', '"n":"'.$to.'"');
		foreach (self::findMany($q) as $r) {
			foreach ($r->getDates() as $d) {
				if (!isset($dates[$d])) $dates[$d] = [];
				$dates[$d][] = $r;
			}
		}
		ksort($dates);
		foreach ($dates as $date => $routes)
			foreach ($routes as $route)
				$res[] = [$date, $route];
		$res = array_slice($res, 0, 1);
		return $res;
	}
}
