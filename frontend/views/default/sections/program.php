<?php
/* @var $courseModules array */
/* @var $isGuest bool */
/* @var $model \common\models\Course */
?>
<section id="course-program">
    <div class="container">
        <div class="row">
            <? if (!$isGuest) : ?>
                <h2 class="section-title">Программа обучения</h2>
                <div class="col-md-12 table-wrapper">
                    <table class="program-table">
                        <tr>
                            <th>Название модуля, раздела</th>
                            <th>Тип контроля знаний</th>
                        </tr>
                        <? foreach ($courseModules as $module): ?>
                            <tr>
                                <td class="module-title"><?= $module->title ?></td>
                                <td><?= $module->isTest() ? 'Тест' : '' ?></td>
                            </tr>
                        <? endforeach; ?>
                        <tr>
                            <td class="module-title">Итоговая атестация</td>
                            <td>
                                Экзамен
                            </td>
                        </tr>
                    </table>
                </div>
            <? else : ?>
                <h2 class="section-title">Описание курса</h2>
                <div class="description">
                    <?= $model->description ?>
                </div>
            <? endif; ?>
        </div>
    </div>
</section>