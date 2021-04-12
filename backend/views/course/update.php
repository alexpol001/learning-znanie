<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $image array */
/* @var $imageDocument array */

$this->title = 'Изменить: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="course-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
        'imageDocument' => $imageDocument,
    ]) ?>

</div>
