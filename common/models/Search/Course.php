<?php

namespace common\models\Search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Course as CourseModel;
use yii\db\Query;

/**
 * Course represents the model behind the search form of `common\models\Course`.
 */
class Course extends CourseModel
{
    public $studentId = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'hours', 'type', 'test_time'], 'integer'],
            [['title', 'image'], 'safe'],
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

        $query = CourseModel::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($this->studentId) {
            $studentCourseQuery = new Query();
            $studentCourseQuery = $studentCourseQuery->from(StudentCourse::tableName())->where(['=', 'student_id', $this->studentId])->all();
            foreach ($studentCourseQuery as $value) {
                $query->andWhere(['!=', 'id', $value['course_id']]);
            }
        }

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'hours' => $this->hours,
            'type' => $this->type,
            'test_time' => $this->test_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
