<?php
namespace SimpleAddressBook\Form;
use Zend\Form\Form;
class ContactForm extends Form
{
	const PATTERN_PHONE = '^([\(]{1}[0-9]{3}[\)]{1}[\.| |\-]{0,1}|^[0-9]{3}[\.|\-| ]?)?[0-9]{3}(\.|\-| )?[0-9]{4}$';
	const TITLE_PHONE = '###-###=####';
	const ERR_PHONE = 'Please input valid phone number.';

	private static $stateList = array(
			null => '---',
			'AL'=>'Alabama',
			'AK'=>'Alaska',
			'AZ'=>'Arizona',
			'AR'=>'Arkansas',
			'CA'=>'California',
			'CO'=>'Colorado',
			'CT'=>'Connecticut',
			'DE'=>'Delaware',
			'DC'=>'District Of Columbia',
			'FL'=>'Florida',
			'GA'=>'Georgia',
			'HI'=>'Hawaii',
			'ID'=>'Idaho',
			'IL'=>'Illinois',
			'IN'=>'Indiana',
			'IA'=>'Iowa',
			'KS'=>'Kansas',
			'KY'=>'Kentucky',
			'LA'=>'Louisiana',
			'ME'=>'Maine',
			'MD'=>'Maryland',
			'MA'=>'Massachusetts',
			'MI'=>'Michigan',
			'MN'=>'Minnesota',
			'MS'=>'Mississippi',
			'MO'=>'Missouri',
			'MT'=>'Montana',
			'NE'=>'Nebraska',
			'NV'=>'Nevada',
			'NH'=>'New Hampshire',
			'NJ'=>'New Jersey',
			'NM'=>'New Mexico',
			'NY'=>'New York',
			'NC'=>'North Carolina',
			'ND'=>'North Dakota',
			'OH'=>'Ohio',
			'OK'=>'Oklahoma',
			'OR'=>'Oregon',
			'PA'=>'Pennsylvania',
			'RI'=>'Rhode Island',
			'SC'=>'South Carolina',
			'SD'=>'South Dakota',
			'TN'=>'Tennessee',
			'TX'=>'Texas',
			'UT'=>'Utah',
			'VT'=>'Vermont',
			'VA'=>'Virginia',
			'WA'=>'Washington',
			'WV'=>'West Virginia',
			'WI'=>'Wisconsin',
			'WY'=>'Wyoming');

	public function __construct($name = null)
	{
		// ignore the name passed
		parent::__construct('contact');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		$this->add(array(
				'name' => 'first_name',
				'attributes' => array(
						'type'  => 'text',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'First name',
				),
		));
		$this->add(array(
				'name' => 'last_name',
				'attributes' => array(
						'type'  => 'text',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Last name',
				),
		));
		$this->add(array(
				'name' => 'email',
				'attributes' => array(
						'type'  => 'email',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Email address',
				),
		));
		$this->add(array(
				'name' => 'phone',
				'attributes' => array(
						'type'  => 'phone',
						'required' => 'required',
						'pattern' => self::PATTERN_PHONE,
						'title' => self::TITLE_PHONE,
						'errormessage' => self::ERR_PHONE
				),
				'options' => array(
						'label' => 'Phone number',
				),
		));
		$this->add(array(
				'name' => 'city',
				'attributes' => array(
						'type'  => 'text',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'City',
				),
		));
		$this->add(array(
				'name' => 'state',
				'attributes' => array(
						'type'  => 'select',
						'required' => 'required',
						'options' => self::$stateList,
				),
				'options' => array(
						'label' => 'State',
						'strict' => true
				),
		));
		$this->add(array(
				'name' => 'zip',
				'attributes' => array(
						'type'  => 'text',
						'required' => 'required',
						'title' => '#####',
						'pattern' => '^((\d{5}-\d{4})|(\d{5})|([A-Z]\d[A-Z]\s\d[A-Z]\d))$'
				),
				'options' => array(
						'label' => 'Zip code',
				),
		));
		$this->add(array(
				'name' => 'web_addr',
				'attributes' => array(
						'type'  => 'url',
				),
				'options' => array(
						'label' => 'Web address',
				),
		));
		$this->add(array(
				'name' => 'second_phone',
				'attributes' => array(
						'type'  => 'phone',
						'pattern' => self::PATTERN_PHONE,
						'title' => self::TITLE_PHONE,
						'errormessage' => self::ERR_PHONE
				),
				'options' => array(
						'label' => '2nd phone number',
				),
		));
		$this->add(array(
				'name' => 'street_addr',
				'attributes' => array(
						'type'  => 'text',
				),
				'options' => array(
						'label' => 'Street Address',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go'
				),
		));
	}
}