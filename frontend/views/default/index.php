<?php

use common\components\Common;
use frontend\components\Frontend;

/* @var $this yii\web\View */

$this->title = Frontend::getTitle();
?>
    <section id="course-category">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Дистанционные курсы профессиональной переподготовки
                    и повышения квалификации </h2>
                <div class="col-md-4">
                    <div class="course-categories-item">
                        <h3><?= Common::QUALIFICATION ?></h3>
                        <a href="<?= Frontend::getUrlCourseType(Common::QUALIFICATION_URL) ?>">Смотреть</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="course-categories-item">
                        <h3><?= Common::PROFESSIONAL ?></h3>
                        <a href="<?= Frontend::getUrlCourseType(Common::PROFESSIONAL_URL) ?>">Смотреть</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="course-categories-item">
                        <h3><?= Common::PROFESSIONAL_LEARNING ?></h3>
                        <a href="<?= Frontend::getUrlCourseType(Common::PROFESSIONAL_LEARNING_URL) ?>">Смотреть</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->render('sections/advantage') ?>
<?= $this->render('sections/technology') ?>
<?= $this->render('sections/document', [
    'full' => true
]); ?>
<?= $this->render('sections/licence'); ?>
