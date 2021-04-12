<?php

use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */

?>
<div class="timer">
    <div class="unit-time days">
        <div class="time-value">
            0
        </div>
        <div class="unit-time-title">
            Дней
        </div>
    </div>
    <div class="time-division">:</div>
    <div class="unit-time hours">
        <div class="time-value">
            0
        </div>
        <div class="unit-time-title">
            Часов
        </div>
    </div>
    <div class="time-division">:</div>
    <div class="unit-time minutes">
        <div class="time-value">
            0
        </div>
        <div class="unit-time-title">
            Минут
        </div>
    </div>
    <div class="time-division">:</div>
    <div class="unit-time second">
        <div class="time-value">
            0
        </div>
        <div class="unit-time-title">
            Секунд
        </div>
    </div>
</div>
<?php
$this->registerJs(Frontend::getScriptCountDown($studentCourse), yii\web\View::POS_READY);
?>