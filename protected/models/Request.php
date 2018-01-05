<?php

class Request extends ActiveRecord
{
	public function tableName()
	{
		return 'request';
	}

	public function rules()
	{
		return array(
            array('id_destination, declared_place_count, declared_weight, declared_volume, declared_cargo_type, declared_package_type, shipper_name, consignee_name, who_pays', 'required'),
            array('id_user, id_destination, declared_place_count, declared_weight, place_count, weight, id_storage, id_shipping, lattice, packaging, seal, warmth', 'numerical', 'integerOnly'=>true),
            array('declared_volume, volume', 'numerical'),
            array('status, who_pays', 'length', 'max'=>20),
            array('declared_cargo_type, shipper_name, consignee_name, forwarding_contacts, delivery_contacts', 'length', 'max'=>200),
            array('declared_package_type, shipper_kpp, shipper_okpo, consignee_kpp, consignee_okpo', 'length', 'max'=>50),
            array('shipper_address, consignee_address, forwarding_address, delivery_address', 'length', 'max'=>500),
            array('forwarding_working_hours, delivery_working_hours', 'length', 'max'=>100),
        );
	}

	public function relations()
	{
		return array(
			'destination'=>array(self::BELONGS_TO, 'Station', 'id_destination'),
			'storage'=>array(self::BELONGS_TO, 'Storage', 'id_storage'),
			'shipping'=>array(self::BELONGS_TO, 'Shipping', 'id_shipping'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatus()
	{
		$statuses = ['new'=>'Новая','storage'=>'На складе ', 'loaded'=>'Погружен в вагон '];
		$status = $statuses[$this->status];
		if ($this->status == 'storage')
			$status .= $this->storage->name;
		if ($this->status == 'loaded')
			$status .= $this->shipping->railcar->number;
		return $status;
	}

	public function setShipping($shipping)
	{
		$this->id_shipping = $shipping->id;
		$this->status = 'loaded';
		$this->update(['id_shipping', 'status']);
	}

	public function getAppropriateStorage()
	{
		$storage = Storage::findOne(['id_destination'=>$this->id_destination]);
		if (!$storage) $storage = Storage::findOne(['is_default'=>1]);
		return $storage;
	}

	public function getDepartureName()
	{
		return 'Москва-Пассажирская-Ярославская';
	}

	public function getShippingCost()
	{
		return $this->weight * 15;
	}

	public function getLatticeCost()
	{
		return $this->lattice ? round($this->volume * 600) : 0;
	}

	public function getPackagingCost()
	{
		return $this->packaging ? round($this->volume * 500) : 0;
	}

	public function getSealCost()
	{
		return $this->seal ? round($this->volume * 400) : 0;
	}

	public function getDeliveryCost()
	{
		return 3000;
	}

	public function getTotalCost()
	{
		$cost = $this->getShippingCost();
		if ($this->warmth) $cost *= 1.25;
		$cost += $this->getLatticeCost() + $this->getPackagingCost() + $this->getSealCost() + $this->getDeliveryCost();
		return $cost;
	}

	public static function getParticipantTypeName($type)
	{
		$types = ['entity'=>'Юр. лицо', 'person'=>'Физ. лицо'];
		return isset($types[$type]) ? $types[$type] : '';
	}

	public static function getPartTypeName($type)
	{
		$types = ['shipper'=>'Грузоотправитель', 'consignee'=>'Грузополучатель'];
		return isset($types[$type]) ? $types[$type] : '';
	}

	public function getServicesNames()
	{
		$services = ['lattice'=>'Обрешётка','packaging'=>'Упаковка','seal'=>'Пломба','warmth'=>'Доставка в тепле'];
		$applied = [];
		foreach ($services as $t=>$n)
			if ($this->$t)
				$applied[] = $n;
		return implode(', ', $applied);
	}
}
