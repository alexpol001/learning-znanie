<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Student */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'phone',
        'email:email',
        [
            'attribute' => 'organization_name',
            'visible' => !empty($model->organization_name),
        ],
        [
            'attribute' => 'date_over',
            'visible' => $model->is_archive,
        ],
    ],
]) ?>
