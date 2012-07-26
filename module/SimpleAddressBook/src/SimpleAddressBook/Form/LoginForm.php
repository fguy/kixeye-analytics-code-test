<?php
namespace SimpleAddressBook\Form;
use Zend\Form\Form;
class LoginForm extends Form
{
	public function __construct($name = null)
	{
		// ignore the name passed
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'email',
				'attributes' => array(
						'type'  => 'email',
						'required' => 'required',
						'placeholder' => 'Your email address to login'
				),
				'options' => array(
						'label' => 'Email address',
				),
		));
		$this->add(array(
				'name' => 'password',
				'attributes' => array(
						'type'  => 'password',
						'required' => 'required'
				),
				'options' => array(
						'label' => 'Password',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Login'
				),
		));
	}
}