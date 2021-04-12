<?php

namespace common\models\Search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentCourse as StudentCourseModel;

/**
 * Course represents the model behind the search form of `common\models\Course`.
 */
class StudentCourse extends StudentCourseModel
{
    public $studentId = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'active_at', 'status', 'examine_at', 'result', 'attempt', 'fail_at'], 'integer'],
            [['course_id'], 'safe'],
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

        $query = StudentCourseModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($this->studentId) {
            $query->where(['=', 'student_id', $this->studentId]);
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
            'student_id' => $this->student_id,
            'active_at' => $this->active_at,
            'status' => $this->status,
            'examine_at' => $this->examine_at,
            'result' => $this->result,
            'attempt' => $this->attempt,
            'fail_at' => $this->fail_at,
        ]);

        $query->andFilterWhere(['like', 'zpd_course.title', $this->course_id]);

        return $dataProvider;
    }
}
