<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Course */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Course */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Модули'
?>
<div class="course-module-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('../elements/course_info', ['model' => $model]) ?>
    <h2><?= Html::encode('Модули') ?></h2>
    <p>
        <?= Html::a('Добавить Модуль', ['module-create?id='.$model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->title), Url::to(['module-view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>

</div>
