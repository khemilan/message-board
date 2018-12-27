<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('Validation', 'Utility');

class User extends AppModel {
	public $hasMany =[
		'Messages' =>[
			'className' => 'Message',
		]
	];

	public $validate = [
		'name' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Name is required'
			],
			'size' => [
				'rule' => ['lengthBetween', 5, 20],
				'message' => 'Name should be between 5 to 20 characters'
			],
		],
		'email' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Email is required'
			],
			'isUnique' => [
				'rule' => 'emailExists',
				'message' => 'Email already exists, input another email address',
			],
			'isValid' => [
				'rule' => 'validEmail',
				'message' => 'Email must be valid',
			],
		],
		'password' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Password is required'
			]
		],
		'confirmPassword' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Confirm password is required'
			],
			'passwordMatches' => [
				'rule' => 'passwordMatches',
				'message' => 'Password and Confirm password must match'
			]
		],
		'image' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Upload your profile image'
			],
			'rule' => [
				'extension',
				['gif', 'png', 'jpg']
			],
			'message' => 'Supply a valid image.'
		],
		'birthdate' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Birthdate is required'
			]
		],
		'gender' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Gender is required'
			]
		],
		'hobby' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Fill in your hobbies'
			]
		],
	];

	public function passwordMatches() {
		return $this->data[$this->alias]['password'] == $this->data[$this->alias]['confirmPassword'];
	}

	public function emailExists() {
		$data = $this->findByEmail($this->data[$this->alias]['email']);
		return empty($data);
	}

	public function validEmail() {
		return Validation::email($this->data[$this->alias]['email']);
	}

	public function beforeSave($options = []) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
}