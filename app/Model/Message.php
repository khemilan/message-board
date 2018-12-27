<?php

class Message extends AppModel {
	public $belongsTo = [
		'User' => [
			'className' => 'User',
			'foreignKey' => 'from_id',
		]
	];

	public $hasMany =[
		'Reply' =>[
			'className' => 'Reply',
			'foreignKey' => 'message_id',
			'dependent' => true,
		]
	];

	public $validate = [
		'to_id' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Please select recipient'
			],
		],
		'content' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Please type message'
			],
		],
	];
}
