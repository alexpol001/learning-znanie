<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\components\Frontend;

/* @var $this yii\web\View */
/* @var $isOrganization bool */
/* @var $model \frontend\models\SignupForm */

$this->title = Frontend::getTitle(['Регистрация'])
?>
<section id="auth">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <h2>
                    <span class="auth-title">Регистрация</span>
                    <a href="<?= Frontend::getUrlRegistration() ?>"
                       class="toggle <?= $isOrganization ? '' : 'active' ?>">Для физических лиц</a>
                    <a href="<?= Frontend::getUrlRegistration('organization') ?>"
                       class="toggle <?= $isOrganization ? 'active' : '' ?>">Для организаций</a>
                </h2>
                <div class="form">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group warning">
                        Все поля обязательны для регистрации
                    </div>

                    <? if ($isOrganization) : ?>
                        <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>
                    <? endif; ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <div class="terms">
                        <? $urlTerm = Frontend::getUrlTerms() ?>
                        <?= $form->field($model, 'acordul_tc')
                            ->checkbox([
                                'label' => "Согласен на обработку персональных данных*
<p style=\"margin-top: 5px\"><a href=\"$urlTerm\">Политика в отношении обработки персональных данных</a></p>",
                                'checked' => false, 'required' => true]); ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>