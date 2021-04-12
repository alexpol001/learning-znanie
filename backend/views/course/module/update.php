<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $moduleModel common\models\CourseModule */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Модули', 'url' => ['module', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => $moduleModel->title, 'url' => ['module-view', 'id' => $moduleModel->id]];
$this->params['breadcrumbs'][] = 'Редактировать модуль'
?>
<div class="course-module-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('../elements/course_info', ['model' => $model]) ?>
    <h2><?= Html::encode($moduleModel->title.' - Редактировать модуль') ?></h2>
    <?= $this->render('_form', [
        'model' => $moduleModel,
        'course_id' => $model['id'],
    ]) ?>

</div>
