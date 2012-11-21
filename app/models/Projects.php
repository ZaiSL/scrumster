<?php


class Projects extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var string
     *
     */
    public $title;

	public function initialize() {
		$this->hasMany('id', 'Issues', 'project_id');
	}
}
