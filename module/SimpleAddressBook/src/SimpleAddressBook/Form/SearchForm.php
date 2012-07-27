<?php
namespace SimpleAddressBook\Form;
use Zend\Form\Form;
class SearchForm extends Form
{
	public function __construct($name = null)
	{
		// ignore the name passed
		parent::__construct('search');
		$this->setAttribute('method', 'get');
		$this->add(array(
				'name' => 'q',
				'attributes' => array(
						'type'  => 'text',
						'required' => 'required',
						'placeholder' => 'Search',
						'id' => 'search-query'
				),
				'options' => array(
						'label' => 'Search',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Search'
				),
		));
	}
}