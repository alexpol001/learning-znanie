<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setting-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'add_time_course') ?>

    <?= $form->field($model, 'examine_period') ?>

    <?= $form->field($model, 'sale') ?>

    <?= $form->field($model, 'right_answer') ?>

    <!--    --><? //= $form->field($model, 'max_answer') ?>

    <?= $form->field($model, 'instruction')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple' => false       // возможность выбора нескольких файлов
    ]);

    ?>

    <?= $form->field($model, 'politics')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple' => false       // возможность выбора нескольких файлов
    ]);

    ?>

    <?= $form->field($model, 'instruction_text')->widget(\dominus77\tinymce\TinyMce::className(), [
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
