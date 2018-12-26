<?php

class MessagesController extends AppController {
    public $components = ['Paginator'];

    public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('Reply');
    }

    public function index() {
        $limit = array_key_exists('n', $this->request->query) ? (int) $this->request->query['n'] : 5;
        $this->Paginator->settings = [
            'fields' => ['Message.id'],
            'conditions' => [
                'OR' => [
                    'Message.to_id' => $this->Auth->user('id'),
                    'Message.from_id' => $this->Auth->user('id'),
                ],
            ],
            'order' => 'Message.created DESC',
            'recursive' => -1,
            'limit' => $limit,
        ];
        $messageId =$this->Paginator->paginate('Message');

        $messages = [];
        if (!empty($messageId)) {
            foreach ($messageId as $message) {
                $replyData = $this->Message->find('first',[
                    'fields' => [
                        'Message.id', 'Message.to_id', 'Message.from_id', 'Message.content', 'Message.created',
                        'Reply.id', 'Reply.content', 'Reply.created',
                        'IF(Reply.from_id = User1.id, User1.name, User2.name) AS replySender',
                        'IF(Reply.from_id = User1.id, User2.name, User1.name) AS replyRecipient',
                        'IF(Reply.from_id = User1.id, User1.image, User2.image) AS imageSender',
                        'IF(Reply.from_id = User1.id, User2.image, User1.image) AS imageRecipient',
                    ],
                   'conditions' => [
                        'Message.id' => $message['Message']['id'],
                    ],
                    'joins' => [
                         [
                            'table' => 'replies',
                            'alias' => 'Reply',
                            'type' => 'LEFT',
                            'conditions' => [
                                'Message.id = Reply.message_id',
                            ],
                        ],
                        [
                            'table' => 'users',
                            'alias' => 'User1',
                            'type' => 'INNER',
                            'conditions' => [
                                'Message.from_id = User1.id',
                            ],
                        ],[
                            'table' => 'users',
                            'alias' => 'User2',
                            'type' => 'INNER',
                            'conditions' => [
                                'Message.to_id = User2.id',
                            ],
                        ]
                    ],
                    'order' => 'Reply.created DESC',
                    'recursive' => -1,
                ]);

                # format result data
                $isSentByUser = $replyData[0]['replySender'] == $this->Auth->user('name');
                $messages[$message['Message']['id']] = [
                    'id' => $replyData['Message']['id'],
                    'name' => $isSentByUser ? $replyData[0]['replyRecipient'] : $replyData[0]['replySender'],
                    'image' => $isSentByUser ? $replyData[0]['imageRecipient'] : $replyData[0]['imageSender'],
                    'content' => $replyData['Reply']['content'],
                    'date' => date('Y/m/d H:i', strtotime($replyData['Reply']['created'])),
                    'isSentByUser' => $isSentByUser,
                ];
            }

            # sort by date in descending order
            $sortArray = [];
            foreach($messages as $message){
                foreach($message as $key=>$value){
                    if(!isset($sortArray[$key])){
                        $sortArray[$key] = [];
                    }
                    $sortArray[$key][] = $value;
                }
            }
            array_multisort($sortArray["date"], SORT_DESC, $messages);
        }

        $nextLimit = $limit + 10;
        $this->set(compact('messages', 'nextLimit'));
    }

    public function add() {
        $users = $this->_setOptionData();

        if ($this->request->is('post')) {
            $this->Message->set($this->request->data);
            if ($this->Message->validates()) {
                # check if message thread already exists
                $messages = $this->_checkMessageExists($this->request->data['Message']['to_id']);

                if (empty($messages)) {
                    # message thread does not exist, save message thread and reply data
                    $this->request->data['Message']['from_id'] = (int)$this->Auth->user('id');
                    $this->request->data['Message']['to_id'] = (int)$this->request->data['Message']['to_id'];
                    if ($this->Message->save($this->request->data)) {
                        $reply = [
                            'Reply' => [
                                'message_id' => $this->Message->getLastInsertId(),
                                'from_id' => $this->Auth->user('id'),
                                'content' => $this->request->data['Message']['content'],
                            ],
                        ];

                        if ($this->Reply->save($reply)) {
                            return $this->redirect(['action' => 'index']);
                        }
                    }
                } else {
                    # message thread already exists, save reply data only
                    $reply = [
                        'Reply' => [
                            'message_id' => $messages['Message']['id'],
                            'from_id' => $this->Auth->user('id'),
                            'content' => $this->request->data['Message']['content'],
                        ],
                    ];

                    if ($this->Reply->save($reply)) {
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
        }

        $this->set(compact('users'));
    }

    public function detail($messageId) {
        $limit = array_key_exists('n', $this->request->query) ? (int) $this->request->query['n'] : 5;
        $this->Paginator->settings = [
             'fields' => [
                'Reply.id', 'Reply.content', 'Reply.created',
                'User.name', 'User.image'
            ],
            'conditions' => [
                'Reply.message_id' => $messageId,
            ],
            'joins' => [
               [
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => [
                        'Reply.from_id = User.id',
                    ],
                ]
            ],
            'order' => 'Reply.created DESC',
            'recursive' => -1,
            'limit' => $limit
        ];
        $replyData =$this->Paginator->paginate('Reply');

        # format result data
        $replies = [];
        foreach ($replyData as $key => $data) {
            $replies[$key] = [
                'id' => $data['Reply']['id'],
                'name' => $data['User']['name'],
                'image' => $data['User']['image'] ?: Configure::read('default.image'),
                'date' => date('Y/m/d H:i', strtotime($data['Reply']['created'])),
                'content' => $data['Reply']['content'],
                'isSentByUser' => $data['User']['name'] == $this->Auth->user('name'),
            ];
        }

        $nextLimit = $limit + 10;
        $this->set(compact('replies', 'messageId', 'nextLimit'));
    }

    public function delete() {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $data = $this->request->data;
            if ($this->Message->delete($data)) {
                return json_encode($data);
            }
        }
    }

    /**
     * Checks if message thread already exists
     * @param  string $userId id of user
     * @return array message data
     */
    private function _checkMessageExists($userId) {
        return $this->Message->find('first', [
            'fields' => ['Message.id'],
            'conditions' => [
                'OR' => [
                    ['AND' => [
                        ['Message.from_id' => $this->Auth->user('id')],
                        ['Message.to_id' => $userId],
                    ]],
                    ['AND' => [
                        ['Message.to_id' => $this->Auth->user('id')],
                        ['Message.from_id' => $userId],
                    ]]
                ]
            ],
            'recursive' => -1,
        ]);
    }

    /**
     * Set option data for recipient dropdown in add messages view
     * @return array option data
     */
    private function _setOptionData() {
        # get all users except current user
        $this->loadModel('User');
        $users = $this->User->find('all', [
            'fields' => ['User.id', 'User.name', 'User.image'],
            'conditions' => [
                'User.id !=' => $this->Auth->user('id'),
            ],
            'recursive' => -1,
        ]);

        # format options
        $options = [];
        foreach($users as $key => $user) {
            $options[$key] = [
                'name' => $user['User']['name'],
                'value' => $user['User']['id'],
                'data-image' => $user['User']['image'] ?: '',
            ];
        }
        array_unshift($options, ['name' => '', 'value' => '', 'data-image' => '']);

        return $options;
    }
}
?>
