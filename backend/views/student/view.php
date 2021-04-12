<?php

use common\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый пароль', ['new-password', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Курсы', ['course', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <? if ($model->is_archive) : ?>
            <?= Html::a('Удалить из архива', ['update', 'id' => $model->id, 'is_archive' => 0], ['class' => 'btn btn-danger']) ?>
        <? else: ?>
            <?= Html::a('Добавить в архив', ['update', 'id' => $model->id, 'is_archive' => 1], ['class' => 'btn btn-warning']) ?>
        <? endif; ?>
        <? if (!User::isUserAdmin($model->email)) : ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы действительно хотите удалить данного пользователя?',
                    'method' => 'post',
                ],
            ]) ?>
        <? endif; ?>
    </p>
    <?= $this->render('elements/student_info', ['model' => $model]) ?>

</div>
