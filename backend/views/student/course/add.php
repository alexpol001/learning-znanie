<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\Course */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Student */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['course', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Добавить курс';
?>
<div class="student-view">

    <h1><?= Html::encode($this->title.' - Добавить курс') ?></h1>
    <?= $this->render('../elements/student_info', ['model' => $model]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                    'value' => function ($data) use ($model) {
                        return Html::a('Активировать', ['add-course?id='.$model->id.'&course_id='.$data->id], [
                            'class' => 'btn btn-success',
                            'data' => [
                                'confirm' => 'Вы действительно хотите активировать курс ('.$data->title.') для данного пользователя?',
                            ],
                        ]);
                    },
                'format' => 'raw',
            ],
        ],
    ]); ?>
</div>
