<?php
/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */

?>

ФИО <?= $studentCourse->studentId0->name ?>

Телефон: <?= $studentCourse->studentId0->phone ?>

Email: <?= $studentCourse->studentId0->userId0->email ?>

<? if (!empty($studentCourse->studentId0->organization_name)): ?>Организация: <?= $studentCourse->studentId0->organization_name ?><? endif; ?>

Курс &laquo;<?= $studentCourse->courseId0->title ?>&raquo; завершен!
