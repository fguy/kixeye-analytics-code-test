<?php
namespace SimpleAddressBook\Auth;

use Zend\Authentication\Adapter\AdapterInterface;

class Adapter implements AdapterInterface
{
	/**
	 * Sets username and password for authentication
	 *
	 * @return void
	 */
	public function __construct($username, $password)
	{
		// ...
	}

	/**
	 * Performs an authentication attempt
	 *
	 * @return \Zend\Authentication\Result
	 * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
	 *               If authentication cannot be performed
	 */
	public function authenticate()
	{
		// ...
	}
}