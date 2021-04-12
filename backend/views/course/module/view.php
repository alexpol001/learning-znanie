<?php

use backend\components\Backend;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Course */
/* @var $moduleModel \common\models\CourseModule */
/* @var $files_add array */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Модули', 'url' => ['module', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $moduleModel->title
?>
<div class="course-module-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('../elements/course_info', ['model' => $model]) ?>
    <h2><?= Html::encode('Модуль: (' . $moduleModel->title . ')') ?></h2>
    <p>
        <?= Html::a('Редактировать', ['module-update', 'id' => $moduleModel->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['module-delete?id=' . $moduleModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить модуль (' . $moduleModel->title . ')?',
            ],
        ]);
        ?>
    </p>
    <p>
        <?
        echo \yii\helpers\Html::label('Материалы модуля');

        echo \kartik\file\FileInput::widget([
            'name' => 'materials',
            'options' => [
                'accept' => '*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'uploadUrl' => \yii\helpers\Url::to(['module-upload']),
                'maxFileSize' => 1000000,
                'uploadExtraData' => [
                    'module_id' => $moduleModel->id,
                ],
                'overwriteInitial' => false,
                'initialPreview' => $files_add,
                'initialPreviewFileType' => 'object',
                'initialPreviewConfig' => Backend::getCourseModuleMaterialFileArray($files_add, $moduleModel->id),
                'initialPreviewAsData' => true,
                'showUpload' => true,
                'showRemove' => false,
            ]
        ]);
        ?>
    </p>
    <p>
        <?= Html::a('Вопросы к модулю', ['question', 'id' => $moduleModel->id, 'type' => 'module'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
