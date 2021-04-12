<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\Student */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Студенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->name), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            'email',
            'organization_name',
            [
                'attribute' => 'course_id',
                'filter' => \common\models\Student::getSelectCourses(),
                'value' => function ($data) {
                    return \common\models\Course::findOne($data->course_id)->title;
                },
            ],
            [
                'label' => 'Дата начала обучения',
                'value' => function ($data) {
                    if ($data->studentCourse)
                        return date('d/m/y', $data->studentCourse->active_at - (($data->studentCourse->courseId0->hours * 3.2) * 60 * 60));
                    return null;
                },
                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center'],
                'headerOptions' => ['style' => 'vertical-align: middle; text-align: center'],
            ],
            [
                'attribute' => 'date_over',
                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center'],
                'headerOptions' => ['style' => 'vertical-align: middle; text-align: center'],
            ],
            [
                'label' => 'Процент сдачи экзамена',
                'value' => function ($data) {
                    if ($data->studentCourse && $data->studentCourse->result)
                        return $data->studentCourse->result . '%';
                    return null;
                },
                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center'],
                'headerOptions' => ['style' => 'vertical-align: middle; text-align: center'],
            ],
        ],
    ]); ?>
</div>
