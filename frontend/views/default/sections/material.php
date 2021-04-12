<?php

use common\components\Common;
use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $courseModules array */
/* @var $studentCourse \common\models\StudentCourse */
/* @var $model \common\models\Course */

?>
<section id="course-materials">
    <div class="container">
        <div class="row">
            <h2 class="section-title">Материалы для обучения</h2>
            <div class="col-md-12 table-wrapper">
                <table class="materials-table">
                    <tr>
                        <th>Название модуля, раздела</th>
                        <th>Материалы курса</th>
                    </tr>
                    <? /** @var \common\models\CourseModule $module */
                    foreach ($courseModules as $module): ?>
                        <? if ($materials = Common::getUrlCourseModuleMaterials($module->id)): ?>
                            <tr>
                                <td class="module-title"><?= $module->title ?></td>
                                <td>
                                    <? foreach ($materials as $material): ?>
                                        <div class="module-item">
                                            <a href="<?= $material ?>"><?= basename($material) ?></a>
                                        </div>
                                    <? endforeach; ?>
                                    <? if ($module->materials) :?>
                                    <div class="module-item">
                                        <a href="#" data-toggle="modal" data-target="#myModalModule<?=$module->id?>">Видеоматериалы</a>
                                        <?= $this->render('../elements/videomaterials', [
                                                'module' => $module,
                                        ]) ?>
                                    </div>
                                    <? endif; ?>
                                    <? if ($module->isTest()) : ?>
                                        <div class="module-item">
                                            <a href="<?=Frontend::getUrlModuleTest($module) ?>"><?= 'Пройти тест' ?></a>
                                        </div>
                                    <? endif; ?>
                                </td>
                            </tr>
                        <? endif; ?>
                        <? if ($module->isTest() && !$studentCourse->isModuleComplete($module)) {
                            break;
                        } ?>
                    <? endforeach; ?>
                </table>
            </div>
            <div class="course-info col-md-10 col-md-offset-1">
                <p>
                    Выберите учебный материал и нажмите на ссылку что бы скачать его.<br>
                </p>
                <? $setting = \common\models\Setting::getSetting(); ?>
                <p>
                    Обратите свое внимание.<br>
                    Вы должны успеть сдать экзамен до окончания времени. Для этого у вас есть две попытки. Если
                    первый раз у вас не получилось, то вам будет дополнительно начислено <?=Frontend::plural_form($setting->add_time_course, ['час', 'часа', 'часов'])?> для завершения курса,
                    а возможность сдать экзамен повторно будет доступна через <?=Frontend::plural_form($setting->examine_period, ['минуту', 'минуты', 'минут'])?> после первого прохождения. </p>
                <p class="warning">
                    После истечения времени доступ к курсу будет закрыт.
                </p>
                <div class="alert-course">

                </div>
                <p class="time-warning">До закрытия курса осталось:</p>
            </div>
            <div class="align-center col-md-11 col-md-offset-1">
                <?=$this->render('../elements/timer', ['studentCourse' => $studentCourse])?>
                <a class="to-exam<?=!$studentCourse->isModulesComplete() ? ' disabled' : ''?>" href="<?= Frontend::getUrlExamine($model) ?>">Сдать экзамен</a>
            </div>
        </div>
    </div>
</section>
