<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\Backend;


/* @var $this yii\web\View */
/* @var $model \common\models\Course */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'hours')->textInput() ?>

    <?= $form->field($model, 'file')->widget(\kartik\file\FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg', 'png', 'gif'],
            'initialPreview' => $image,
            'initialPreviewConfig' => [
                [
                    'showRemove' => false,
                    'showDrag' => false,
                ],

            ],
            'showUpload' => false,
            'showRemove' => true,
            'dropZoneEnabled' => false,
        ]
    ]);
    ?>

    <?= $form->field($model, 'type')->dropDownList(Backend::getCourseTypeArray()) ?>

    <?= $form->field($model, 'test_time')->textInput(['placeholder' => '60']) ?>

    <?= $form->field($model, 'documentFile')->widget(\kartik\file\FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg', 'png', 'gif'],
            'initialPreview' => $imageDocument,
            'initialPreviewConfig' => [
                [
                    'showRemove' => false,
                    'showDrag' => false,
                ],

            ],
            'showUpload' => false,
            'showRemove' => true,
            'dropZoneEnabled' => false,
        ]
    ]);
    ?>

    <?= $form->field($model, 'description')->widget(\dominus77\tinymce\TinyMce::className(), [
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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
