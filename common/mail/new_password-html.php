<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $password string*/
$link = \common\components\Common::getAbsoluteUrlLogin();
?>
<div class="new-password">
    <p><b>Ваш пароль для входа на сайт: <?= Html::encode($password) ?></b></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>

    <p>Никому не сообщайте свой пароль!</p>
</div>
