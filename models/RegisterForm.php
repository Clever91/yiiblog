<?php 

namespace app\models;

use Yii;
use yii\base\Model;

/**
* @author Clever91
*/
class RegisterForm extends Model
{
	public $name;
	public $username;
	public $email;
	public $password;
	public $verifyCode;

	public function rules()
	{
		return [
			[['name', 'username', 'email', 'password'], 'required'],
			['name', 'string', 'min' => 3],
			['username', 'string', 'min' => 3],
			['email', 'email'],
			['verifyCode', 'captcha'],
			['email', 'unique', 'targetClass' => 'app\models\Users', 'targetAttribute' => 'email'],
			['username', 'unique', 'targetClass' => 'app\models\Users', 'targetAttribute' => 'username'],
		];
	}

	public function attributeLabels()
	{
		return [
			'verifyCode' => 'Verification Code',
		];
	}

	public function createUser()
	{
		if ($this->validate()) {

			$user = new Users();
	        $user->attributes = $this->attributes;
	        $user->generatePassword();
	        
	        return $user->save();
        }

        return false;
	}
}

?>