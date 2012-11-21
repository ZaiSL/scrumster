<?php


class Issues extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var integer
     *
     */
    public $project_id;

    /**
     * @var integer
     *
     */
    public $sprint_id;

    /**
     * @var string
     *
     */
    public $type;

    /**
     * @var string
     *
     */
    public $title;

    /**
     * @var string
     *
     */
    public $description;

    /**
     * @var integer
     *
     */
    public $estimate;

    /**
     * @var integer
     *
     */
    public $is_feature;

    /**
     * @var integer
     *
     */
    public $stage;

    /**
     * @var integer
     *
     */
    public $owner_id;

    /**
     * @var integer
     *
     */
    public $assigned_to;

    /**
     * @var integer
     *
     */
    public $parent_feature_id;

    /**
     * @var string
     *
     */
    public $created_at;

	public function initialize() {
		$this->belongsTo('user_id', 'Users', 'id');
		$this->belongsTo('project_id', 'Projects', 'id');
	}

}
