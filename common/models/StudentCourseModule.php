<?php

namespace common\models;

/**
 * This is the model class for table "{{%student_course_module}}".
 *
 * @property int $id
 * @property int $student_course_id
 * @property int $module_id
 */
class StudentCourseModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%student_course_module}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_course_id', 'module_id'], 'required'],
            [['student_course_id', 'module_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_course_id' => 'Student Course ID',
            'module_id' => 'Module ID',
        ];
    }

    public static function active($studentCourse, $module)
    {
        if (!self::findOne(['student_course_id' => $studentCourse->id, 'module_id' => $module->id])) {
            $scm = new StudentCourseModule();
            $scm->student_course_id = $studentCourse->id;
            $scm->module_id = $module->id;
            $scm->save();
        }
    }
}
