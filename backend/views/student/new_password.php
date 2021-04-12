<?php

use backend\components\Backend;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $modelForm \backend\models\NewPasswordForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Новый пароль';
?>
<div class="student-view">

    <h1><?= Html::encode($this->title.' - Новый пароль') ?></h1>
    <?= $this->render('elements/student_info', ['model' => $model]) ?>
    <?php $form = ActiveForm::begin(); ?>
    <?
        $modelForm->password = Backend::GenPassword();
        echo $form->field($modelForm, 'password')->textInput(['style' => 'font-weight: bold;']);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
