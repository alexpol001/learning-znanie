<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse*/
$link = \common\components\Common::getAbsoluteUrlCourse($studentCourse->courseId0);
?>
<div class="active-course">
    <p><b>Курс &laquo;<?=$studentCourse->courseId0->title?>&raquo; активирован!</b></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>

    <p>Торопитесь время прохождения курса ограничено!</p>
</div>


