<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $student \common\models\Student */

?>
<div class="new-student">
    <p>ФИО: <?= Html::encode($student->name) ?></p>

    <p>Телефон: <?= Html::encode($student->phone) ?></p>

    <p>Email: <?= Html::encode($student->userId0->email) ?></p>

    <? if (!empty($student->organization_name)):?><p>Организация: <?= Html::encode($student->organization_name) ?></p> <?endif;?>
</div>
