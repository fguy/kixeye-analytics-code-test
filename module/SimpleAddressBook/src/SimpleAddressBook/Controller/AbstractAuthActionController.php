<?php
namespace SimpleAddressBook\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\SessionManager;
use SimpleAddressBook\Form\LoginForm;
use SimpleAddressBook\Model\User;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result as Zend_Auth_Result;

abstract class AbstractAuthActionController extends AbstractActionController
{
	const TTL = 60;

	protected $user;
	private $auth;

	public function __construct()
	{
		$this->auth = new AuthenticationService();
		$manager = new SessionManager();
		$manager->getConfig()->setCookieLifetime(self::TTL);
		$this->auth->setStorage(new SessionStorage(null, null, $manager));
	}

	public function execute(MvcEvent $e)
	{
		if($this->auth->hasIdentity())
		{
			$this->user = new User();
			$this->user->email = $this->auth->getIdentity();
		}
		else
		{
			$e->getRouteMatch()->setParam('action', 'login');
		}
		return parent::execute($e);
	}

	public function loginAction() {
		$form = new LoginForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$authAdapter = new AuthAdapter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'), 'user','email','password','MD5(?)');
				$authAdapter->setIdentity($data['email'])->setCredential($data['password']);
				$result = $this->auth->authenticate($authAdapter);

				switch ($result->getCode()) {
					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
						/** do stuff for nonexistent identity **/
						break;

					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
						/** do stuff for invalid credential **/
						break;

					case Zend_Auth_Result::SUCCESS:
						return $this->redirect()->toRoute('simple-address-book');
						break;

					default:
						/** do stuff for other failure **/
						break;
				}
			}
		}
		return array('form' => $form);
	}

	public function logOutAction() {
		$this->auth->clearIdentity();
	}
}