<?php

namespace common\models\Search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student as StudentModel;

/**
 * Student represents the model behind the search form of `common\models\Student`.
 */
class Student extends StudentModel
{
    public $course_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'is_archive'], 'integer'],
            [['name', 'phone', 'email', 'organization_name', 'date_over'], 'safe'],
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
        $query = StudentModel::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('studentCourse');
        $this->load($params);
        if ($this->is_archive) {
            /** @var Student $student */
            foreach (\common\models\Student::find()->all() as $student) {
                if (!$student->is_archive) {
                    $query->andWhere(['<>', 'zpd_student.id', $student->id]);
                }
            }
        } else {
            /** @var Student $student */
            foreach (\common\models\Student::find()->all() as $student) {
                if ($student->is_archive) {
                    $query->andWhere(['<>', 'zpd_student.id', $student->id]);
                }
            }
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_archive' => $this->is_archive,
            'zpd_student_course.course_id' => $this->course_id,
            'zpd_student_course.status' => $this->course_status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'date_over', $this->date_over])
            ->andFilterWhere(['like', 'organization_name', $this->organization_name]);

        return $dataProvider;
    }
}
