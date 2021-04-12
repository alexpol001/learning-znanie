<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Course */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот курс?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= $this->render('elements/course_info', ['model' => $model]) ?>
    <p>
        <?= Html::a('Модули', ['module', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Вопросы к экзамену', ['question', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
