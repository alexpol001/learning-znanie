<?php

use frontend\components\Frontend;

/* @var $this yii\web\View */
$this->title = Frontend::getTitle(['Вопросы/Ответы']);
?>
<?=
$this->render('sections/faq', [
    'isGray' => true,
]);
?>
