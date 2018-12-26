<?php

class RepliesController extends AppController {

	public function add() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$data['Reply'] = $this->request->data;
			$data['Reply']['from_id'] = $this->Auth->user('id');

			if ($this->Reply->save($data)){
				$data = $this->Reply->findById($this->Reply->getLastInsertId());
				$data['Reply']['name'] = $this->Auth->user('name');
				$data['Reply']['created'] = date('Y/m/d H:i', strtotime($data['Reply']['created']));
			 	return json_encode($data['Reply']);
			}
		}
	}

	public function delete() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			if ($this->Reply->delete($this->request->data)) {
				return json_encode($this->request->data);
			}
		}
	}

}