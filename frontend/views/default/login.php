<?php

use frontend\components\Frontend;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var \common\models\LoginForm $model */

$this->title = Frontend::getTitle(['Вход']);
?>
<section id="auth">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <h2><span class="auth-title">Вход</span></h2>
                <div class="form login">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= '<div class="form-group warning">
                            Все поля обязательны для регистрации
                        </div>' ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>