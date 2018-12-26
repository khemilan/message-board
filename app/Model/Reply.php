<?php 

class Reply extends AppModel {
	public $belongsTo = [
	 	'Message' => [
		 	'className' => 'Message',
		 	'foreignKey' => 'message_id',
	 	]
	 ];

	 public $validate = [
        'content' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'Name is required'
            ],
        ],
     ];
}
?>