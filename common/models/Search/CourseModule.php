<?php

namespace common\models\Search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CourseModule as CourseModuleModel;

/**
 * Course represents the model behind the search form of `common\models\CourseModule`.
 */
class CourseModule extends CourseModuleModel
{

    public $courseId = false;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id'], 'integer'],
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

        $query = CourseModuleModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($this->courseId) {
            $query->where(['=', 'course_id', $this->courseId]);
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
            'course_id' => $this->course_id,
        ]);

        $query->andFilterWhere(['like', 'zpd_course_module.title', $this->title]);

        return $dataProvider;
    }
}
