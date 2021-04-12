<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $course_id int */
/* @var $module_id int */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $answerModels array */
/* @var $answerModel \common\models\QuestionAnswer */

?>

<div class="course-question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea() ?>

    <?= $form->field($model, 'course_id')->hiddenInput(['value' => $course_id])->label(false)?>

    <?= $form->field($model, 'module_id')->hiddenInput(['value' => $module_id])->label(false)?>

    <? for ($i = 0; $i < \common\models\Setting::getSetting()->max_answer; $i++): ?>
        <?= $form->field($answerModel, 'title[]', ['options' => ['class' => 'inline'], 'enableClientValidation' => false])->textarea(['value' => $answerModels[$i]->title])->label('Ответ '.($i + 1))?>

        <?= $form->field($answerModel, 'is_right[]', ['options' => ['class' => 'inline'], 'enableClientValidation' => false])->checkbox(['checked ' => (bool) $answerModels[$i]->is_right])?>

        <?= $form->field($answerModel, 'question_id[]')->hiddenInput(['value' => $model['id'] ? $model['id'] : '0'])->label(false)?>
    <? endfor; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
