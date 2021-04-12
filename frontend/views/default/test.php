<?php

use frontend\components\Frontend;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $studentCourse \common\models\StudentCourse */
/* @var $isOneAnswer bool */
/* @var $question \common\models\Question */
/* @var $numberQuestion int */
/* @var $countQuestions int */
/* @var $courseModule \common\models\CourseModule */

$this->title = Frontend::getTitle(['Экзамен', $studentCourse->courseId0->title]);
?>
    <section id="test">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2>
                        <? if ($courseModule) { ?>
                            Тест «<?= $studentCourse->courseId0->title.' - '.$courseModule->title ?>»
                        <? } else { ?>
                            Экзамен «<?= $studentCourse->courseId0->title ?>»
                        <? } ?>
                    </h2>
                    <div class="test-info">
                        <p class="action-select">
                            <? if ($isOneAnswer) { ?>
                                Выберите один правильный ответ.
                            <? } else { ?>
                                Выберите несколько правильных ответов.
                            <? } ?>
                        </p>
                        <? if (!$courseModule) : ?>
                            <p class="last-time">00:00:00</p>
                            <?
                            $this->registerJs(Frontend::getScriptCountDownExamine(Frontend::getLastTimeExamine($studentCourse)), yii\web\View::POS_READY);
                            ?>
                        <? endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="question">
                        <h3 class="question-title"><?= $question->title ?></h3>
                        <?= Html::beginForm() ?>
                        <?= Html::hiddenInput('question', $question->id) ?>
                        <div class="answer">
                            <? if ($isOneAnswer) { ?>
                                <div class="list" aria-required="true">
                                    <? foreach ($question->answers as $key => $answer) : ?>
                                        <label><input name="answers" value="<?= $key ?>"
                                                      type="radio"> <?= $answer->title ?></label>
                                    <? endforeach; ?>
                                </div>
                            <? } else { ?>
                                <div class="list" aria-required="true">
                                    <? foreach ($question->answers as $key => $answer) : ?>
                                        <label><input name="answers[]" value="<?= $key ?>"
                                                      type="checkbox"> <?= $answer->title ?></label>
                                    <? endforeach; ?>
                                </div>
                            <? } ?>
                        </div>
                        <div class="question-control">
                            <div class="col-sm-3">
                                <?= Html::submitButton('Ответить', ['class' => 'to-answer', 'name' => 'answer', 'value' => 'answer']) ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="question-number">Вопрос <?= $numberQuestion ?>
                                    из <?= $countQuestions ?></div>
                            </div>
                            <div class="col-sm-3 align-right">
                                <?= Html::submitButton('Пропустить', ['class' => 'to-miss', 'name' => 'miss', 'value' => 'miss']) ?>
                            </div>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? /** @var \common\models\Course $model */
if ($model = $studentCourse->courseId0 && $model->document) : ?>
    <?= $this->render('sections/document', [
        'model' => $model,
    ]) ?>
<? endif; ?>
