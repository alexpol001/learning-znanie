<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\components\Backend;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\Student */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Student */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Курсы';
?>
<div class="student-course-index">

    <h1><?= Html::encode($this->title.' - Курсы') ?></h1>
    <?= $this->render('../elements/student_info', ['model' => $model]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                    'attribute' => 'course_id',
                'value' => function ($data) use ($model) {
                    return Html::a(Html::encode($data->courseId0->title), Url::to(['course-view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return Backend::getCourseStatus($data->status);
                },
                'filter' => Backend::getCourseStatusArray(),
                'format'=>'raw',
            ]
        ],
    ]); ?>
    <?= Html::a('Добавить курс', ['add-course?id='.$model->id], ['class' => 'btn btn-success']) ?>
</div>
