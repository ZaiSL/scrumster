<?php
/**
 * php console.php user create имя пароль
 */
class UserTask extends \Phalcon\CLI\Task
{
    public function createAction($name = 'admin', $pass = 'admin')
    {
		$salt = rand().rand();
		
        $user = new Users();
		$user->username = $name;
		$user->password = sha1($pass.$salt).':'.$salt;
		$user->email = $name.'@'.$name.'.ru';
		$user->avatar = $name;
		$user->save();
    }
}
