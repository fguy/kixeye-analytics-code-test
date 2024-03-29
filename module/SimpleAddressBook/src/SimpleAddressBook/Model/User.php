<?php
namespace SimpleAddressBook\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface {
	public $email;
	public $password;

	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
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
			$inputFilter->add($factory->createInput(array(
					'name'     => 'password',
					'required' => true
			)));
				
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}