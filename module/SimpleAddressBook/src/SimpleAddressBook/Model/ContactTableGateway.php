<?php
namespace SimpleAddressBook\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
class ContactTableGateway extends AbstractTableGateway
{
	protected $table ='contact';
	private $user;
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Contact());
		$this->initialize();
	}
	public function setUser(User $user)
	{
		$this->user = $user;
	}
	public function fetchAll()
	{
		return $this->select(array('owner' => $this->user->email));
	}
	public function getOne($id)
	{
		$id  = (int) $id;
		$rowset = $this->select(array('owner' => $this->user->email, 'id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	public function save(Contact $contact)
	{
		$data = array(
				'id' => $contact->id,
				'owner' => $this->user->email,
				'first_name' => $contact->first_name,
				'last_name' => $contact->last_name,
				'email' => $contact->email,
				'phone' => $contact->phone,
				'city' => $contact->city,
				'state' => $contact->state,
				'zip' => $contact->zip,
				'web_addr' => $contact->web_addr,
				'second_phone' => $contact->second_phone,
				'street_addr' => $contact->street_addr,
		);
		$id = (int) $contact->id;
		if ($id == 0) {
			$this->insert($data);
		} else {
			if ($this->getOne($id)) {
				$this->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}
	public function del($id)
	{
		$this->delete(array('owner' => $this->user->email, 'id' => $id));
	}
}