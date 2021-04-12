<?php
/** @var bool $full */

use common\components\Common;

/** @var \common\models\Course $model */
?>
<section id="document">
    <div class="container">
        <h2 class="section-title mark-title">Выдаваемые документы</h2>
        <div class="document-item">
            <div class="row">
                <? if ($full) :?>
                <div class="document-description col-md-5">
                    <h3>Диплом о професиональной переподготовки</h3>
                    <div class="short-border"></div>
                    <p>При окончании
                        обучения выполучите
                        диплом, соответствующий
                        всем требованиям государства.
                        Это официальный документ,
                        который признается по всей России.</p>
                </div>
                <div class="document-sample col-md-6">
<!--                    <img src="/assets/img/home/diplom.jpg">-->
                </div>
                <? else : ?>
                    <div class="document-description col-md-5">
                        <h3><?=$model->type ? 'Удостоверение о повышении квалификации' : 'Диплом о професиональной переподготовки'?></h3>
                        <div class="short-border"></div>
                        <p>При окончании
                            обучения выполучите
                            <?=$model->type ? 'удостоверение' : 'диплом'?>, соответствующий
                            всем требованиям государства.
                            Это официальный документ,
                            который признается по всей России.</p>
                    </div>
                    <div class="document-sample col-md-6">
                        <img src="<?=Common::getUrlCourseDocument($model->document)?>">
                    </div>
                <? endif; ?>
            </div>
        </div>

        <? if ($full) : ?>
            <div class="document-item">
                <div class="row">
                    <div class="document-description col-md-5 col-md-push-6">
                        <h3>Удостоверение о повышении
                            квалификации</h3>
                        <div class="short-border"></div>
                        <p>При окончании обучения
                            вы получите удостоверение,
                            соответствующее всем
                            требованиям государства.
                            Это официальный документ,
                            который признается по всей России.</p>
                    </div>
                    <div class="document-sample col-md-6 col-md-pull-6">
                        <img src="/assets/img/home/udostoverenie.jpg">
                    </div>
                </div>
            </div>
        <? endif; ?>
    </div>
</section>
