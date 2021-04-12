<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\components\Common;
use frontend\widgets\ConsultantWidget;
use frontend\widgets\OnlineCallWidget;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use frontend\assets\MainAsset;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= Common::getAbsoluteUrlFavicon() ?>" type="image/x-icon"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <h1 class="hidden">Дистанционные курсы профессиональной переподготовки и повышения квалификации Учебный центр
        Знания</h1>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('danger')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('danger'); ?>
        </div>
    <?php endif; ?>
    <header id="main-head">
        <div id="top">
            <div class="container">
                <div class="top-menu">
                    <a href="/">Главная</a>
                    <? if ($instruction = \common\models\Setting::getSetting()->instruction) : ?>
                        <a href="<?= $instruction ?>">Инструкция пользователя</a>
                    <? endif; ?>
                </div>
            </div>
        </div>
        <?php
        NavBar::begin([
            'brandImage' => '/assets/img/logo.jpg',
            'brandLabel' => 'Yii::$app->name',
            'brandUrl' => 'http://znanie-pskov.ru/',
            'options' => [
                'class' => 'navbar',
            ],
        ]);
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Вход', 'url' => ['/default/login']];
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/default/registration']];
        } else {
            $menuItems[] = '<li><span class="name">' .
                Common::GetStudentNameByUserEmail(Yii::$app->user->identity->email)
                . '</span></li>';
            $menuItems[] = [
                'label' => 'Выход', 'url' => ['/default/logout']];;
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    </header>
    <?= $content ?>
    <footer id="main-foot">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h4>О нас</h4>
                    <ul>
                        <li><a href="http://znanie-pskov.ru/about-us/contact-us">Контакты</a></li>
                        <li><a href="http://znanie-pskov.ru/2015-08-21-03-23-23">Реквизиты</a></li>
                        <li><a href="http://znanie-pskov.ru/litsenziya">Лицензии</a></li>
                        <li><a href="http://znanie-pskov.ru/about-us/cvedeniya-ob-obrazovatelnoj-organizasii">Сведения
                                об образовательной организации</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-md-offset-4">
                    <h4>Дополнительно</h4>
                    <ul>
                        <li><a href="http://znanie-pskov.ru/arenda-zalov">Аренда залов</a></li>
                        <li><a href="http://znanie-pskov.ru/classes/forma-zayavki">Форма заявки</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="long-border"></div>
                </div>
                <div class="col-md-12">
                    <p class="copyright">Все права защищены © <?= date("Y"); ?> Учебный центр ЗНАНИЯ <br>
                        Сайт разработан Digital-агентством &laquo;<a href="http://symbweb.ru" target="_blank"
                                                                     title="Самые качественные сайты!">Симбиоз</a>&raquo;
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <?= OnlineCallWidget::widget([]) ?>
    <?= ConsultantWidget::widget([]) ?>

    <?
    $this->endBody();
    ?>


    </body>
    </html>

<?
$this->endPage();
?>
