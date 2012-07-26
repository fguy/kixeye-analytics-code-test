<?php
namespace SimpleAddressBook\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SimpleAddressBook\Form\ContactForm;
use SimpleAddressBook\Model\Contact;

class ContactController extends AbstractAuthActionController
{
	private $tableGateway;
	const MODULE_NAME = 'simple-address-book';

	public function indexAction()
	{
		return new ViewModel(array(
				'contact_list' => $this->getTableGateway()->fetchAll(),
		));
	}

	public function addAction()
	{
		$form = new ContactForm();
		$form->get('submit')->setAttribute('value', 'Add');
		$request = $this->getRequest();
		if ($request->isPost()) {
			$contact = new Contact();
			$form->setInputFilter($contact->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$contact->exchangeArray($form->getData());
				$this->getTableGateway()->save($contact);
				return $this->redirect()->toRoute(self::MODULE_NAME);
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		$id = (int) $this->params('id');
		if (!$id) {
			return $this->redirect()->toRoute(self::MODULE_NAME, array('action'=>'add'));
		}
		$contact = $this->getTableGateway()->getOne($id);
		$form = new ContactForm();
		$form->bind($contact);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$this->getTableGateway()->save($contact);
				return $this->redirect()->toRoute('self::MODULE_NAME');
			}
		}
		return array(
				'id' => $id,
				'form' => $form,
		);
	}

	public function deleteAction()
	{
		$id = (int) $this->params('id');
		if (!$id) {
			return $this->redirect()->toRoute(self::MODULE_NAME);
		}
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost()->get('del', 'No');
			if ($del == 'Yes') {
				$id = (int) $request->getPost()->getOne('id');
				$this->getTableGateway()->delete($id);
			}
			return $this->redirect()->toRoute(self::MODULE_NAME);
		}
		return array(
				'id' => $id,
				'contact' => $this->getTableGateway()->getOne($id)
		);
	}

	private function getTableGateway()
	{
		if (!$this->tableGateway) {
			$this->tableGateway = $this->getServiceLocator()->get('SimpleAddressBook\Model\ContactTableGateway');
			$this->tableGateway->setUser($this->user);
		}
		return $this->tableGateway;
	}
}
