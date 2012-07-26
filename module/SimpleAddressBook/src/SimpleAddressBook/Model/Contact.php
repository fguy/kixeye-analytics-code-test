<?php
namespace SimpleAddressBook\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Contact implements InputFilterAwareInterface
{
	public $id;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $city;
	public $state;
	public $zip;

	// optional fields
	public $webAddr;
	public $secondPhone;
	public $streetAddr;

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception("Not used");
	}

	public function exchangeArray($data)
	{
		$this->id     = (isset($data['id'])) ? $data['id'] : null;
		$this->firstName     = $data['first_name'];
		$this->lastName     = $data['last_name'];
		$this->email = $data['email'];
		$this->phone = $data['phone'];
		$this->city = $data['city'];
		$this->state = $data['state'];
		$this->zip = $data['zip'];
		$this->webAddr     = (isset($data['web_addr'])) ? $data['web_addr'] : null;
		$this->secondPhone     = (isset($data['second_phone'])) ? $data['second_phone'] : null;
		$this->streetAddr     = (isset($data['street_addr'])) ? $data['street_addr'] : null;
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$inputFilter->add($factory->createInput(array(
					'name'     => 'first_name',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'last_name',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'phone',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'city',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'state',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'zip',
					'required' => true,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'web_addr',
					'required' => false,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'second_phone',
					'required' => false,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'street_addr',
					'required' => false,
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'email',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'EmailAddress'
							),
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 255,
									),
							),
					),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}