<?php

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */
$link = \common\components\Common::getAbsoluteUrlCourse($studentCourse->courseId0);
?>
Курс "<?= $studentCourse->courseId0->title ?>" активирован!

<?= $link ?>

Торопитесь время прохождения курса ограничено!