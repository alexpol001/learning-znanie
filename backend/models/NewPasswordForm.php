<?

namespace backend\models;

use common\models\User;
use common\components\Common;
use yii\base\Model;

class NewPasswordForm extends Model{

    public $password;


    public function rules(){

        return [
            [['password'], 'required'],
            ['password', 'string', 'min' => 6],
            ];
    }

    /**
     * @param $email
     * @return null|string
     * @throws \yii\base\Exception
     */
    public function changePassword($email){
        if($this->validate()){
            if ($user = User::findByUserEmail($email)) {
                $user->setPassword($this->password);
                if ($user->save(true,['password_hash'])) {
                    $user->sendEmailAboutNewPassword($this->password);
                    return Common::GetStudentNameByUserEmail($user->email);
                }
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
        ];
    }
}