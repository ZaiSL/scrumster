<?php

class ApiController extends \Phalcon\Mvc\Controller {

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
		
		$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
		$this->success_answer_items($issues);
	}
	
	/**
	 * Добавление ишью
	 */
	public function issueAddAction() {
		
		
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
		
		$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
		$this->success_answer_items($users);
	}
	
	/**
	 * Добавление юзера
	 */
	public function userAddAction() {
		
		
	}
	
	private function success_answer_items($items) {
		
		echo json_encode(array(
			'success' => true,
			'message' => 'ok',
			'items'   => $items,
		));
	}
}
