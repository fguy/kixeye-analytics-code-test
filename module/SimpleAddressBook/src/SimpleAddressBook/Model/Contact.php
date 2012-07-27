<?php
namespace SimpleAddressBook\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Contact implements InputFilterAwareInterface
{
	public $id;
	public $first_name;
	public $last_name;
	public $email;
	public $phone;
	public $city;
	public $state;
	public $zip;

	// optional fields
	public $web_addr;
	public $second_phone;
	public $street_addr;

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception("Not used");
	}

	public function exchangeArray($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->first_name = $data['first_name'];
		$this->last_name = $data['last_name'];
		$this->email = $data['email'];
		$this->phone = $data['phone'];
		$this->city = $data['city'];
		$this->state = $data['state'];
		$this->zip = $data['zip'];
		$this->web_addr     = (isset($data['web_addr'])) ? $data['web_addr'] : null;
		$this->second_phone     = (isset($data['second_phone'])) ? $data['second_phone'] : null;
		$this->street_addr     = (isset($data['street_addr'])) ? $data['street_addr'] : null;
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$inputFilter->add($factory->createInput(array(
					'name'     => 'id',
					'required' => false,
			)));
			
			$inputFilter->add($factory->createInput(array(
					'name'     => 'first_name',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'last_name',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'phone',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'city',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'state',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'zip',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),					
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'web_addr',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
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