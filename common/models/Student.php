<?php

namespace common\models;

use backend\components\Backend;
use common\components\Common;
use frontend\models\SignupForm;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $organization_name
 * @property string $date_over
 * @property User userId0
 * @property StudentCourse studentCourse
 * @property int $course_id
 * @property int $course_status
 * @property int $is_archive
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['phone', 'email', 'organization_name'], 'string', 'max' => 50],
            [['name', 'date_over'], 'string', 'max' => 150],
            [['email'], 'email'],
            [['is_archive'], 'integer'],
        ];
    }

    public static function getSelectCourses()
    {
        $courses = Course::find();
        return ArrayHelper::map($courses->all(), 'id', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Курс',
            'name' => 'ФИО',
            'phone' => 'Номер телефона',
            'email' => 'Email',
            'organization_name' => 'Название организации',
            'date_over' => 'Дата окончания обучения'
        ];
    }

    public function getStudentCourse() {
        return $this->hasOne(StudentCourse::className(), ['student_id' => 'id']);
    }

    public function getCourseId0()
    {
        return $this->hasOne(Course::className(), ['studentCourse.course_id' => 'course_id']);
    }

    public function getCourse_id() {
        return $this->studentCourse->courseId0->id;
    }

    public function getCourse_status() {
        return $this->studentCourse->status;
    }

    public function getUserId0()
    {
        return $this->hasOne(User::className(), ['student_id' => 'id']);
    }

    public static function findByStudentEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($user = User::findByStudent($this->id)) {
            $user->email = $this->email;
            $user->save(false);
        } else {
            $user = new SignupForm();
            $user->student_id = $this->id;
            $user->email = $this->email;
            $user->password = Backend::GenPassword();
            if ($user->signup()) {
                $this->sendEmailAboutRegistration();
            } else {
                $this->delete();
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        Common::deleteAll(StudentCourse::findAll(['student_id' => $this->id]));
        User::findByUserEmail($this->email)->delete();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    private function sendEmailAboutRegistration() {
        return Yii::$app
            ->mail
            ->compose(
                ['html' => 'new_student-html', 'text' => 'new_student-text'],
                ['student' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo(User::getAdmin()->email)
            ->setSubject('Новый студент - ' . Yii::$app->name)
            ->setTextBody('Студент '. $this->name.' зарегистрирован')
            ->send();
    }
}
