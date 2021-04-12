<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\Backend;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $courseModel \common\models\StudentCourse */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['course', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $courseModel->courseId0->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title . ' - Курсы') ?></h1>
    <?= $this->render('../elements/student_info', ['model' => $model]) ?>
    <h2><?= Html::encode('Курс (' . $courseModel->courseId0->title . ')') ?></h2>
    <p>
        <?=
        Html::a('Отключить', ['delete-course?id=' . $courseModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите отключить курс (' . $courseModel->courseId0->title . ') для данного пользователя?',
            ],
        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $courseModel,
        'attributes' => [
            ['attribute' => 'status',
                'value' => function ($data) {
                    return Backend::getCourseStatus($data->status);
                },
                'format' => 'html',
            ],
            ['label' => 'Часов осталось',
                'value' => function ($data) {
                    return \common\components\Common::getLastHours($data);
                },
                'visible' => !($courseModel->status),],
            'attempt',
            ['attribute' => 'result',
                'value' => function ($data) {
                    return $data->result . '%';
                },
                'visible' => ($courseModel->status == 1),
            ],
        ],
    ]) ?>
</div>
