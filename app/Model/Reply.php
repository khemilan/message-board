<?php

class Reply extends AppModel {
	public $belongsTo = [
		'Message' => [
			'className' => 'Message',
			'foreignKey' => 'message_id',
		]
	];
}
?>