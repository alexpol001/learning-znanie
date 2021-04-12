<?php

use common\components\Common;
use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */
/* @var $courseModule \common\models\CourseModule */

$this->title = Frontend::getTitle([$studentCourse->courseId0->title]);
?>
    <section id="course-cover" class="background-third">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-offset-1">
                    <h2>
                        <?= Common::getCoursesTypeTitle($studentCourse->courseId0->type) ?>
                    </h2>
                    <h3 class="test-result">
                        Результаты теста «<?= $studentCourse->courseId0->title.' - '.$courseModule->title ?>»
                    </h3>
                    <p class="test-result">
                        <span class="success"> Вы дали <?= $result['value'] ?>% правильных
                        ответов</span>
                    </p>
                    <div class="test-result">
                        <a href="<?=Frontend::getUrlCourse($studentCourse->courseId0)?>">Продолжить обучение</a>
                        <a href="<?=Frontend::getUrlModuleTest($courseModule)?>">Повторить тестирование</a>
                    </div>
                    <?= $this->render('elements/support') ?>
                </div>
            </div>
        </div>
    </section>
<? if (count($errors = $result['errors'])) :?>
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
<? endif; ?>
<? /** @var \common\models\Course $model */
if ($model = $studentCourse->courseId0 && $model->document) : ?>
    <?= $this->render('sections/document', [
        'model' => $model,
    ]) ?>
<? endif; ?>
