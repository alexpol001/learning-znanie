<?php

namespace common\models\Search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Question as QuestionModel;

/**
 * Course represents the model behind the search form of `common\models\CourseModule`.
 */
class Question extends QuestionModel
{

    public $courseId = false;
    public $moduleId = false;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'module_id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = QuestionModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($this->courseId) {
            $query->where(['=', 'course_id', $this->courseId]);
        }
        if ($this->moduleId) {
            $query->where(['=', 'module_id', $this->moduleId]);
        }
        $query->joinWith('courseId0');
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'zpd_question.course_id' => $this->course_id,
            'zpd_question.module_id' => $this->module_id,
        ]);

        $query->andFilterWhere(['like', 'zpd_question.title', $this->title]);

        return $dataProvider;
    }
}
