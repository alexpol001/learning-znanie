<?php

namespace common\models;

use backend\components\Backend;
use frontend\models\SignupForm;
use yii\base\Model;
use yii\db\StaleObjectException;

class StudentForm extends Model
{
    public $last_name;
    public $first_name;
    public $patronymic;
    public $phone;
    public $email;
    public $organization_name;
    public $acordul_tc;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'patronymic', 'phone', 'email'], 'required'],
            [['last_name', 'first_name', 'patronymic', 'phone', 'email', 'organization_name'], 'string', 'max' => 50],
            [['email'], 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\Student', 'message' => 'Пользователь с таким email адресом уже зарегистрирован.'],
            ['acordul_tc', 'required', 'requiredValue' => 1, 'message' => 'Необоходимо согласиться с пользовательским соглашением']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
            'phone' => 'Номер телефона',
            'email' => 'Email',
            'organization_name' => 'Название организации',
        ];
    }

    /**
     * @return bool|Student|null
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function createStudent()
    {
        if (!$this->validate()) {
            return null;
        }

        $student = new Student();
        $student->name = $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic;
        $student->phone = $this->phone;
        $student->email = $this->email;
        $student->organization_name = $this->organization_name;

        return $student->save();
    }
}
