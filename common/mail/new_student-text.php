<?php

/* @var $this yii\web\View */
/* @var $student \common\models\Student */

?>
ФИО: <?= $student->name ?>,

Телефон: <?= $student->phone ?>,

Email: <?= $student->userId0->email ?>,

<? if (!empty($student->organization_name)):?>Организация: <?= $student->organization_name ?><?endif;?>


