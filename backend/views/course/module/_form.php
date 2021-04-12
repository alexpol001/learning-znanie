<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\CourseModule*/
/* @var $course_id int*/

?>

<div class="course-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'materials')->widget(\dominus77\tinymce\TinyMce::className(), [
        'options' => [
            'rows' => 16,
        ],
        'language' => 'ru',
        'clientOptions' => [
            'menubar' => true,
            'statusbar' => true,
            'theme' => 'modern',
            'plugins' => [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
            ],
            'noneditable_noneditable_class' => 'fa',
            'extended_valid_elements' => 'span[class|style]',
            'toolbar1' => "undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            'toolbar2' => "print preview media | forecolor backcolor emoticons | codesample",
            'image_advtab' => true,
        ],
        'fileManager' => [
            'class' => \dominus77\tinymce\components\MihaildevElFinder::className(),
        ],
    ]);?>

    <?= $form->field($model, 'course_id')->hiddenInput(['value' => $course_id])->label(false)?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
