<?php

namespace common\models;


/**
 * This is the model class for table "{{%question_answer}}".
 *
 * @property int $id
 * @property int $question_id
 * @property string $title
 * @property int $is_right
 */
class QuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%question_answer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'title'], 'required'],
            [['question_id', 'is_right'], 'integer'],
            [['title'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'title' => 'Ответ',
            'is_right' => 'Верно!',
        ];
    }

    public function getQuestionId0()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
