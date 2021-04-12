<?php

use common\components\Common;
use backend\components\Backend;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\Course */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Курсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить курс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->title), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            [
                    'attribute' => 'type',
                    'value' => function ($data) {
                        return Common::getCoursesTypeTitle($data->type);
                    },
                    'filter' => Backend::getCourseTypeArray(),
            ],
            [
                    'attribute' => 'hours'
            ]
        ],
    ]); ?>
</div>
