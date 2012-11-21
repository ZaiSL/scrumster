<?php


class Users extends \Phalcon\Mvc\Model 
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
    public $username;

    /**
     * @var string
     *
     */
    public $password;
	
    /**
     * @var string
     *
     */
    public $email;

    /**
     * @var string
     *
     */
    public $avatar;

	public function initialize() {
		$this->hasMany('id', 'Issues', 'user_id');
	}
}
