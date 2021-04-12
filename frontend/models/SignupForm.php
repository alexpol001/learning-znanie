<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $student_id;
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['student_id', 'required'],
            ['student_id', 'integer'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->student_id = $this->student_id;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
