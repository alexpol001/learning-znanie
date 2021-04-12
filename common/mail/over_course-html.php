<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */

?>
<div class="over-course">
    <p>ФИО <?= Html::encode($studentCourse->studentId0->name) ?></p>

    <p>Телефон: <?= Html::encode($studentCourse->studentId0->phone) ?></p>

    <p>Email: <?= Html::encode($studentCourse->studentId0->userId0->email) ?></p>

    <? if (!empty($studentCourse->studentId0->organization_name)):?><p>Организация: <?= Html::encode($studentCourse->studentId0->organization_name) ?></p> <?endif;?>

    <p><b>Курс &laquo;<?=$studentCourse->courseId0->title?>&raquo; завершен!</b></p>
</div>
