<?php
require_once('autoload.php'); 
 
class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
		//впиши сюда своего юзера
		$name = 'admin';
		$salt = rand().rand();
		
        $user = new Users();
		$user->username = $name;
		$user->password = sha1($name.$salt).':'.$salt;
		$user->email = $name.'@'.$name.'.ru';
		$user->avatar = $name;
		$user->save();
    }
       
}
