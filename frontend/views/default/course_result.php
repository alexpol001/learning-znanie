<?php

use common\components\Common;
use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */
/* @var $isTime bool */
/* @var $result array */
/* @var $errors array|bool */

$this->title = Frontend::getTitle([$studentCourse->courseId0->title]);
?>
    <section id="course-cover" class="background-third">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-offset-1">
                    <h2>
                        <?= Common::getCoursesTypeTitle($studentCourse->courseId0->type) ?>
                    </h2>
                    <? if ($isTime) : ?>
                        <p class="test-result">
                            Вы дали <span class="<?= $result['class'] ?>"><?= $result['value'] ?>%</span> правильных
                            ответов
                        </p>
                    <? endif; ?>
                    <h3 class="test-result">
                        <? if ($isTime) { ?>
                            <span
                            class="<?= $result['class'] ?>"><? if ($result['success']) { ?> Поздравляем, вы успешно сдали экзамен <? } else { ?> К сожалению, вы не сдали экзамен <? } ?>
                            «</span><?= $studentCourse->courseId0->title ?><span class="<?= $result['class'] ?>">
                                »</span>
                        <? } else { ?>
                            <span class="fail">К сожалению,</span> время отведенное на прохождение курса истекло.
                                                                   Вы можете <span class="success green">повторно оплатить и активировать курс</span>.
                        <? } ?>
                    </h3>
                    <h4 class="test-result">
                        <? if ($result['success']) { ?> Мы готовим ваше удостоверение о повышении квалификации,
                            и отправим вам его почтой. <? } else { ?>
                            <? if ($studentCourse->status == 2) { ?>
                                Доступ к курсу скоро будет закрыт.
                            <? } else { ?>
                                Рекомендуем вам лучше подготовиться к следующей пересдаче, которая будет доступна через <?=Frontend::plural_form(\common\models\Setting::getSetting()->examine_period, ['Минуту', 'Минуты', 'Минут'])?>
                            <? } ?>
                        <? } ?>
                    </h4>
                    <?= $this->render('elements/support') ?>
                </div>
            </div>
        </div>
    </section>
<? if (!$result['success'] && $errors) : ?>
    <section id="course-errors">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Неправильные ответы</h2>
                    <? /** @var \common\models\Question $error */
                    foreach ($errors as $error) : ?>
                        <p><?=$error->title?></p>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<? endif ?>
<? /** @var \common\models\Course $model */
if ($model = $studentCourse->courseId0 && $model->document) : ?>
<?= $this->render('sections/document', [
        'model' => $model,
]) ?>
<? endif; ?>
