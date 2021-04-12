<?php

use frontend\components\Frontend;

/* @var $this yii\web\View */
$this->title = Frontend::getTitle(['404']);
?>
<section class="error">
    <div class="container">
        <h2>Сожалеем, но запрашиваемая страница вами страница не найдена!</h2>
    </div>
</section>
