<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Course */

$this->title = 'Добавить курс';
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => [],
        'imageDocument' => [],
    ]) ?>

</div>
