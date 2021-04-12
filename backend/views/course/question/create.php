<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $searchModel common\models\Course */
/* @var $moduleModel common\models\CourseModule */
/* @var $questionModel \common\models\Question*/
/* @var $answerModel \common\models\QuestionAnswer */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
if ($moduleModel) {
    $title = $moduleModel->title.' - ';
    $this->params['breadcrumbs'][] = ['label' => 'Модули', 'url' => ['module', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = ['label' => $moduleModel->title, 'url' => ['module-view', 'id' => $moduleModel->id]];
    $this->params['breadcrumbs'][] = ['label' => 'Вопросы к модулю', 'url' => ['question', 'id' => $moduleModel->id, 'type' => 'module']];
} else {
    $title = '';
    $this->params['breadcrumbs'][] = ['label' => 'Вопросы к экзамену', 'url' => ['question', 'id' => $model->id]];
}
$this->params['breadcrumbs'][] = 'Добавить вопрос';
?>
<div class="course-question-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('../elements/course_info', ['model' => $model]) ?>
    <h2><?= Html::encode($title.'Добавить вопрос') ?></h2>
    <?= $this->render('_form', [
        'model' => $questionModel,
        'course_id' => $moduleModel ? 0 :$model->id,
        'module_id' => $moduleModel ? $moduleModel->id : 0,
        'answerModel' => $answerModel,
    ]) ?>

</div>
