<?php
namespace SimpleAddressBook\Controller;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use SimpleAddressBook\Form\ContactForm;
use SimpleAddressBook\Form\SearchForm;
use SimpleAddressBook\Model\Contact;

class ContactController extends AbstractAuthActionController
{
	private $tableGateway;
	const MODULE_NAME = 'simple-address-book';

	public function indexAction()
	{
		return array(
				'contact_list' => $this->getTableGateway()->fetchAll(),
				'form' => new SearchForm()
		);
	}

	public function addAction()
	{
		$form = new ContactForm();
		$form->get('submit')->setAttribute('value', 'Add');
		$request = $this->getRequest();
		if ($request->isPost()) 
		{
			$contact = new Contact();
			$form->setInputFilter($contact->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) 
			{
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
		$request = $this->getRequest();
		
		$id || ($id = (int) $request->getPost()->get('id'));
		
		if (!$id) 
		{
			return $this->redirect()->toRoute(self::MODULE_NAME, array('action'=>'add'));
		}
		$contact = $this->getTableGateway()->getOne($id);
		$form = new ContactForm();
		$form->bind($contact);
		$form->get('submit')->setAttribute('value', 'Edit');

		if ($request->isPost())
		{
			$form->setData($request->getPost());
			if ($form->isValid()) 
			{
				$this->getTableGateway()->save($contact);
				return $this->redirect()->toRoute(self::MODULE_NAME);
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
		$request = $this->getRequest();
		$isPost = $request->isPost();
		if (!$isPost && !$id) 
		{
			return $this->redirect()->toRoute(self::MODULE_NAME);
		}
		if ($isPost) 
		{
			$del = $request->getPost()->get('del', 'No');
			if ($del == 'Yes') 
			{
				$id = (int) $request->getPost()->get('id');
				$this->getTableGateway()->del($id);
			}
			return $this->redirect()->toRoute(self::MODULE_NAME);
		}
		return array(
				'id' => $id,
				'contact' => $this->getTableGateway()->getOne($id)
		);
	}
	
	public function searchAction() 
	{
		$query = $this->getRequest()->getQuery();
		$q = $query->get('q');
		$form = new SearchForm();
		$form->bind($query);
		$view = new ViewModel(array('contact_list'=>$this->getTableGateway()->find($q), 'form'=>$form));
		$view->setTemplate('simple-address-book/contact/index');
		return $view;
	}
	
	public function autoCompleteAction() 
	{
		$rowset = $this->getTableGateway()->find($this->getRequest()->getQuery()->get('term'));
		$result = array();
		foreach($rowset as $contact)
		{
			$result[] = sprintf('%s %s (%s)', $contact->first_name, $contact->last_name, $contact->email);
		}
		$json = new JsonModel($result);
		echo $json->serialize();
		exit;
	}

	private function getTableGateway()
	{
		if (!$this->tableGateway) 
		{
			$this->tableGateway = $this->getServiceLocator()->get('SimpleAddressBook\Model\ContactTableGateway');
			$this->tableGateway->setUser($this->user);
		}
		return $this->tableGateway;
	}
}
