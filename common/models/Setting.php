<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 * @property int $id
 * @property int $add_time_course
 * @property int $examine_period
 * @property int $sale
 * @property int $max_answer
 * @property int $right_answer
 * @property string $instruction
 * @property string $politics
 * @property string $instruction_text
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_time_course', 'examine_period', 'sale', 'max_answer', 'right_answer'], 'required'],
            [['add_time_course', 'examine_period', 'sale', 'max_answer', 'right_answer'], 'integer'],
            [['instruction', 'politics', 'instruction_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'add_time_course' => 'Дополнительное время курса, которое получит студент после несдачи экзамена (часы)',
            'examine_period' => 'Интервал между попытками сдать экзамен (минуты)',
            'sale' => 'Скидка - не затрагивает реальную стоимость (%)',
            'right_answer' => 'Процент правильных ответов для сдачи экзамена (%)',
            'max_answer' => 'Максимальное количество ответов на вопросы',
            'instruction' => 'Инструкция пользователя',
            'politics' => 'Пользовательское соглашение',
            'instruction_text' => 'Правила организации обучения с применением дистанционных технологий',
        ];
    }

    /**
     * @return Setting|null
     */
    public static function getSetting() {
        return Setting::findOne('id' != '');
    }
}
