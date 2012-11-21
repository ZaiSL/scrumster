<?php

class ApiController extends ControllerBase {

	/**
	 * Список всех ишью - /api/issues/
	 */
	public function issueListAction() {
		
		$issues = array();
		foreach(Issues::find() as $issue) {
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
		}
		
        $this->view->setVar('success',true);
        $this->view->setVar('message','ok');
        $this->view->setVar('items',$issue);
       
	}
	
	/**
	 * Добавление ишью
	 */
	public function issueAddAction() {
        
		$request = new \Phalcon\Http\Request();

		$issue_data = json_decode($request->getRawBody(), true);

		$issue = \Phalcon\Mvc\Model::dumpResult(new Issues(), $issue_data);
		$issue->save();

        $this->view->setVar('success',true);
        $this->view->setVar('message','ok');
        $this->view->setVar('data',$issue);
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
