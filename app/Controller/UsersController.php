<?php

class UsersController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(['logout']);
        $this->User->recursive = -1;
    }

    public function login() {
        if ($this->Auth->user()) {
            return $this->redirect('/messages/');
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->user('id');
                $this->User->save([
                    'last_login_time' => date('Y-m-d H:i:s'),
                    'modified_ip' => $this->request->clientIp()
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Invalid Email or Password', ['key' => 'error']);
            }
        }
    }

    public function registration() {
        if ($this->Auth->user()) {
            return $this->redirect('/messages/');
        }
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            $this->request->data['User']['last_login_time'] = date('Y-m-d H:i:s');
            $this->request->data['User']['created_ip'] = $this->request->clientIp();
            if ($this->User->validates()) {
                if ($this->User->save($this->request->data)) {
                    $this->Auth->login();
                    return $this->render('registrationComplete');
                }
            }
        }
    }

    public function profile() {
        $user = $this->_getUserData($this->Auth->user('id'));
        $this->set(compact('user'));
    }

    public function edit() {
        $data = $this->_getUserData($this->Auth->user('id'));

        if ($this->request->is('post') || $this->request->is('put')) {
            # checks if image is changed and set image data
            $imageData = $this->request->data['User']['image'];
            $this->request->data['User']['image'] = $data['User']['image'];
            if (!empty($imageData['name'])) {
                $this->request->data['User']['image'] = $imageData['name'];
            }

            # unset email validator if email is not changed
            if ($data['User']['email'] == $this->request->data['User']['email']) {
                $this->User->validator()->remove('email');
            }

            $this->User->id = $this->Auth->user('id');
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $this->request->data['User']['birthdate'] = date('Y-m-d', strtotime($this->request->data['User']['birthdate']));
                if ($this->User->save($this->request->data)) {
                    # Move image
                    if (!empty($imageData['name'])) {
                        $this->_saveImage([
                            'tmp_name' => $imageData['tmp_name'],
                            'filename' => $imageData['name']
                        ]);
                    }

                    # Update Auth data and login
                    $newAuth = array_merge($this->Auth->user(), $this->request->data['User']);
                    $this->Auth->login($newAuth);

                    return $this->redirect(['action' => 'profile']);
                }
            }
        } else {
            $this->request->data = $data;
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    private function _getUserData($id) {
        return $this->User->findById($id);
    }

    private function _saveImage($data = []) {
        move_uploaded_file(
            $data['tmp_name'],
            WWW_ROOT . 'img' . DS . 'users' . DS . $data['filename']
        );
    }
}
?>
