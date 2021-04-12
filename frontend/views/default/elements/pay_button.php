<?php
/* @var $model \common\models\Course */
/* @var $student \common\models\Student */
?>
<form class="buy-form" action="https://money.yandex.ru/eshop.xml" method="post">
    <input name="shopId" value="538726" type="hidden" required/>
    <input name="scid" value="816898" type="hidden" required/>
    <input name="sum" value="<?=$model->price?>" type="hidden" min="1" placeholder="0.0" required>
    <input required name="customerNumber" value="<?=$student->name?>" type="hidden"  size="64"/>
    <input name="custName" value="<?=$student->phone?>" type="hidden"/>
    <input name="custEmail" value="<?=$student->email?>" type="hidden"/>
    <input name="orderDetails" value="<?=$model->title?>" type="hidden" >
    <div class="buy-course">
        <input type="submit" value="Оплатить курс">
    </div>
</form>
<!--<div class="buy-course">-->
<!--    <a href="#">Оплатить курс</a>-->
<!--</div>-->