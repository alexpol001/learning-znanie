<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class OnlineCallForm extends Model
{
    public $name;
    public $phone;
    public $body;
    public $check;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['phone', 'name', 'body', 'verifyCode'], 'required'],
            [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => 'Неверный формат сотового телефона'],
            [['check'], 'string', 'max' => 255],
            [['body'], 'string'],
            // email has to be a valid email address
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'captchaAction'=>'default/captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'body' => 'Вопрос',
            'check' => 'Привет бот',
            'verifyCode' => 'Введите капчу*',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        if (!$this->check) {
            return Yii::$app->mail
                ->compose(
                    ['html' => 'online-call/html', 'text' => 'online-call/text'],
                    ['model' => $this]
                )
                ->setTo($email)
                ->setFrom([$email => 'Дистанционное обучение/Учебный центр ЗНАНИЯ'])
                ->setSubject('Заявка с сайта | ' . 'Дистанционное обучение/Учебный центр ЗНАНИЯ')
                ->send();
        }
        return false;
    }
}
