<?php

class ApiController extends ControllerBase {

	/**
	 * Список всех ишью - /api/issues/
	 */
	public function issueListAction() {
		
		$issues = array();
		foreach(Issues::find() as $issue) {
			$issues[] = $issue;
			/*
			$issues[] = array(
				'id' => $issue->id,
				'project_id' => $issue->project_id,
				'sprint_id' => $issue->sprint_id,
				'type' => $issue->type,
				'title' => $issue->title,
				'description' => $issue->description,
				'estimate' => $issue->estimate,
				'is_feature' => $issue->is_feature,
				'stage' => $issue->stage,
				'owner_id' => $issue->owner_id,
				'assigned_to' => $issue->assigned_to,
				'parent_feature_id' => $issue->parent_feature_id,
				'created_at' => $issue->created_at,
			);
			*/
		}
		
        $this->view->setVar('success', true);
        $this->view->setVar('message', 'ok');
        $this->view->setVar('items', $issues);
       
	}
	
	/**
	 * Добавление ишью
	 */
	public function issueAddAction() {

		// Для теста метода можно использовать:
		// curl -i -X POST -d '{"project_id":1,"sprint_id":1,"type":"task","title":"Ой-ой, первый таск","description":"Пивасик, ну","estimate":2,"is_feature":0,"stage":1,"owner_id":1,"assigned_to":0,"parent_feature_id":"1","created_at":0}' http://www.scrumster.local/api/issues/

		$request = new \Phalcon\Http\Request();

		$issue_data = json_decode($request->getRawBody(), true);

		$issue = \Phalcon\Mvc\Model::dumpResult(new Issues(), $issue_data);

		if ($issue->save()) {
			$this->view->setVar('success', true);
			$this->view->setVar('message', 'ok');
			$this->view->setVar('data', $issue);
		} else {
			$this->view->setVar('success', false);
			$this->view->setVar('message', 'Ошибка добавления задачи');
		}

	}
	
	/**
	 * Список всех юзеров
	 */
	public function userListAction() {
		
		$users = array();
		foreach(Users::find() as $user) {
			$users[] = array(
				'id' => $user->id,
				'username' => $user->username,
				'email' => $user->email,
				'avatar' => $user->avatar,
			);
		}

        $this->view->setVar('success',true);
        $this->view->setVar('message','ok');
        $this->view->setVar('items',$users);
	}
	
	/**
	 * Добавление юзера
	 */
	public function userAddAction() {
		
		
	}
}
