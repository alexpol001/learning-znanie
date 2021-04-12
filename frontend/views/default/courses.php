<?php

use common\components\Common;
use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $studentCourses array */
/* @var $courses array */

$this->title = Frontend::getTitle([$title]);
?>
<div class="breadcrumb-block">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://znanie-pskov.ru/">Учебный центр Знания</a></li>
                <li class="breadcrumb-item"><a href="/">Дистанционное обучение</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <div class="short-border"></div>
    </div>
</div>
<section id="courses">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title"><?= $title ?></h2>
                <div class="courses-list">
                    <? if ($studentCourses): ?>
                        <div class="active-courses">
                            <h3>Доступные курсы</h3>
                            <? foreach ($studentCourses as $course) : ?>
                                <div class="course-item">
                                    <div class="col-sm-3">
                                        <div class="course-image"
                                             style='background-image: url("<?= Common::getUrlCourseLogo($course->courseId0->image) ?>");'></div>
                                    </div>
                                    <div class="col-md-7 col-sm-9 course-data">
                                        <h4><?= $course->courseId0->title ?></h4>
                                        <div class="time"><?= $course->courseId0->hours ?> ч.</div>
                                        <div class="price"><?= $course->courseId0->price ?> руб.</div>
                                    </div>
                                    <a href="<?= Frontend::getUrlCourse($course->courseId0) ?>" class="open-course">Смотреть
                                        курс</a>
                                    <div class="clearfix"></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    <? endif; ?>
                    <? if ($courses): ?>
                        <h3>Список курсов</h3>
                        <?
                        foreach ($courses as $course):
                            ?>
                            <div class="course-item">
                                <div class="col-sm-3">
                                    <div class="course-image"
                                         style='background-image: url("<?= Common::getUrlCourseLogo($course->image) ?>");'></div>
                                </div>
                                <div class="col-md-7 col-sm-9 course-data">
                                    <h4><?= $course->title ?></h4>
                                    <div class="time"><?= $course->hours ?> ч.</div>
                                    <div class="price"><?= $course->price ?> руб.</div>
                                </div>
                                <a href="<?= Frontend::getUrlCourse($course) ?>" class="open-course">Смотреть курс</a>
                                <div class="clearfix"></div>
                            </div>
                        <?
                        endforeach;
                        ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>