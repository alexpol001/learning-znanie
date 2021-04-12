<?php

use common\components\Common;
use frontend\components\Frontend;
use common\models\Student;
use common\models\User;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */
/* @var $model \common\models\Course */
/* @var $isGuest bool */
/* @var $courseModules array */

$this->title = Frontend::getTitle([$model->title]);
?>
    <section id="course-cover" class="<?= !$studentCourse ? 'background-second' : '' ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-offset-1">
                    <h2>
                        <?= Common::getCoursesTypeTitle($model->type) ?>
                    </h2>
                    <h3>
                        <?= $model->title ?>
                    </h3>
                    <? if ($studentCourse): ?>
                        <h4>
                            Спасибо за то, что выбрали нас! Добро пожаловать в
                            систему дистанционного обучения.
                        </h4>
                    <? endif; ?>
                </div>
                <div class="col-md-12">
                    <? if ($isGuest) { ?>
                        <div class="sale col-sm-10 col-md-7 col-lg-6 col-lg-offset-1">
                            <div class="sale-power">
                                <h4>Скидка <?= \common\models\Setting::getSetting()->sale ?>%</h4>
                                <span>только до <?= Frontend::getSaleDate() ?></span>
                            </div>
                            <div class="sale-data">
                                <div class="course-time">
                                    <?= $model->hours ?>ч.
                                </div>
                                <div class="old-price">
                                    <?= Frontend::getOldPrice($model->price) ?> руб.
                                </div>
                                <div class="sale-price">
                                    <?= $model->price ?> руб.
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="buy-course">
                            <a href="<?= Frontend::getUrlRegistration() ?>">Записаться на курс</a>
                        </div>
                    <? } else { ?>
                        <? if (!$studentCourse) : ?>
                            <div class="course-not-active col-sm-10 col-md-7 col-lg-6 col-lg-offset-1">
                                <h4>
                                    Ваш курс не активен, произведите оплату
                                    что бы получить доступ.
                                </h4>
                            </div>
                            <?=$this->render('elements/pay_button', [
                                    'model' => $model,
                                    'student' => Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)),
                        ]); ?>
                            <div class="course-not-active col-md-12 col-lg-offset-1">
                                <p class="warning">
                                    После оплаты, активация курса происходит с небольшой задержкой.
                                </p>
                            </div>
                        <? endif; ?>
                    <? } ?>
                </div>
                <? if (!$studentCourse) : ?>
                    <div class="col-md-12">
                        <div class="course-length col-md-3 col-lg-offset-1">
                            <h5>Длительность курса</h5>
                            <p>
                                <?= $model->hours ?> часов
                            </p>
                        </div>
                        <div class="course-form col-md-6 col-md-offset-2">
                            <h5>Форма обучения</h5>
                            <p>
                                Заочная с использованием дистанционных технологий
                                (форма обучения в <?=$model->type ? 'удостоверение' : 'дипломе'?> не указывается)
                            </p>
                        </div>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </section>
<? if ($studentCourse) { ?>
    <?= $this->render('sections/material', [
        'courseModules' => $courseModules,
        'studentCourse' => $studentCourse,
        'model' => $model,
    ]); ?>
<? } else { ?>
    <?= $this->render('sections/program', [
        'courseModules' => $courseModules,
        'isGuest' => $isGuest,
        'model' => $model,
    ]); ?>
    <?= $this->render('sections/technology', [
        'backgroundSecond' => true,
    ]) ?>
<? } ?>
<? if ($model->document) :?>
<?= $this->render('sections/document', [
        'model' => $model
    ]) ?>
<? endif ;?>
<?= $this->render('sections/faq') ?>
