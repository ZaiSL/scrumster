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
    public $email;

    /**
     * @var string
     *
     */
    public $avatar;


    /**
     * Validations and business logic 
     */
    public function validation()
    {        
        $this->validate(new Email(array(
            "field" => "email",
            "required" => true
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
