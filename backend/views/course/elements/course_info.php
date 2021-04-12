<?php

use common\components\Common;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Course */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        'price',
        'hours',
        [
            'attribute' => 'type',
            'value' => function ($data) {
                return Common::getCoursesTypeTitle($data->type);
            }
        ],
        'test_time'
    ],
]) ?>
