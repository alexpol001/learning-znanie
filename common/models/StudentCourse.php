<?php

namespace common\models;

use frontend\components\Frontend;
use Yii;

/**
 * This is the model class for table "{{%student_course}}".
 *
 * @property int $id
 * @property int $student_id
 * @property int $course_id
 * @property int $active_at
 * @property int $status
 * @property int $examine_at
 * @property int $result
 * @property int $attempt
 * @property int $fail_at
 * @property mixed studentCourseExamineQuestions
 * @property Course courseId0
 * @property Student studentId0
 * @property array $studentCourseModules
 */
class StudentCourse extends \yii\db\ActiveRecord
{
    const MAX_ATTEMPT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%student_course}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'course_id', 'active_at'], 'required'],
            [['student_id', 'course_id', 'active_at', 'status', 'examine_at', 'result', 'attempt', 'fail_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'course_id' => 'Название курса',
            'active_at' => 'Active At',
            'status' => 'Состояние',
            'examine_at' => 'Examine At',
            'result' => 'Результат',
            'attempt' => 'Попыток сдать экзамен',
            'fail_at' => 'Fail At',
        ];
    }

    public function getCourseId0()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getStudentId0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    public function getStudentCourseModules()
    {
        return $this->hasMany(StudentCourseModule::className(), ['student_course_id' => 'id']);
    }

    public function isModuleComplete($module)
    {
        return StudentCourseModule::findOne(['student_course_id' => $this->id, 'module_id' => $module->id]) ? true : false;
    }

    public function isModulesComplete() {
        $modules = $this->courseId0->modules;
        $modules_count = 0;
        /** @var CourseModule $module */
        foreach ($modules as $module) {
            if (count($module->questions) > 0) {
                $modules_count++;
            }
        }
        return (count($this->studentCourseModules) >= $modules_count);
    }

    public function startCourse()
    {
        if (Frontend::getLastTimeExamine($this) <= 0) {
            if ($this->attempt >= self::MAX_ATTEMPT) {
                $this->status = 2;
            }
            if ($this->status == 2 || count($this->studentCourseExamineQuestions)) {
                return false;
            }
            $this->examine_at = time();
            $this->attempt++;
            $this->save();
        }
        return true;
    }

    public function toLose()
    {
        if (!$this->status) {
            $this->status = 2;
            $this->save();
        }
    }

    public function toResult($result)
    {
        $this->result = $result['value'];
        $this->active_at += 3600 * Setting::getSetting()->add_time_course;
        $this->fail_at = time() + (Setting::getSetting()->examine_period * 60);
        $this->examine_at = 0;
        if ($result['success']) {
            $this->status = 1;
        } else {
            if ($this->attempt >= self::MAX_ATTEMPT) {
                $this->status = 2;
            }
        }
        $this->save();
        return StudentCourseQuestion::resetStudentCourse($this->id);
    }

    public function isWait() {
        $lastTime = ceil(($this->fail_at - time()) / 60);
        return $lastTime > 0 ? $lastTime : 0;
    }

    public function getStudentCourseExamineQuestions()
    {
        $studentCourseQuestions = $this->hasMany(StudentCourseQuestion::className(), ['student_course_id' => 'id']);
        $studentCourseQuestions->andWhere(['module_id' => 0]);
        return $studentCourseQuestions;
    }

    public function getStudentCourseTestQuestions($module)
    {
        return StudentCourseQuestion::findAll(['student_course_id' => $this->id, 'module_id' => $module->id]);
    }

    public static function getStudentCourseByStudentAndCourse($student_id, $course_id)
    {
        $studentCourse = self::findOne(['student_id' => $student_id, 'course_id' => $course_id]);
        return $studentCourse ? $studentCourse : null;
    }

    public static function getStudentCourseByStudent($student_id)
    {
        $studentCourse = self::find()
            ->where(['student_id' => $student_id])->all();
        return $studentCourse ? $studentCourse : null;
    }

    public static function getStudentCourseByStudentAndType($student_id, $type)
    {
        $studentCourse = self::find()
            ->joinWith('courseId0')
            ->where(['student_id' => $student_id])
            ->andWhere(['zpd_course.type' => $type])
            ->all();
        return $studentCourse ? $studentCourse : null;
    }

    public function beforeDelete()
    {
        StudentCourseModule::deleteAll(['student_course_id' => $this->id]);
        StudentCourseQuestion::resetStudentCourse($this->id);
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status) {
            $this->sendEmailAboutOverCourse();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function afterFind()
    {
        Frontend::checkHours($this);
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function sendEmailAboutActiveCourse() {
        return Yii::$app
            ->mail
            ->compose(
                ['html' => 'active_course-html', 'text' => 'active_course-text'],
                ['studentCourse' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->studentId0->userId0->email)
            ->setSubject('Активирован новый курс - ' . Yii::$app->name)
            ->send();
    }

    private function sendEmailAboutOverCourse() {
        return Yii::$app
            ->mail
            ->compose(
                ['html' => 'over_course-html', 'text' => 'over_course-text'],
                ['studentCourse' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo(User::getAdmin()->email)
            ->setSubject('Курс завершен - ' . Yii::$app->name)
            ->send();
    }
}
