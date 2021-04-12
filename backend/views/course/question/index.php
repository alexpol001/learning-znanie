<?php


use backend\components\Backend;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $searchModel common\models\Course */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $moduleModel common\models\CourseModule */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
if ($moduleModel) {
    $title = $moduleModel->title.' - ';
    $this->params['breadcrumbs'][] = ['label' => 'Модули', 'url' => ['module', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = ['label' => $moduleModel->title, 'url' => ['module-view', 'id' => $moduleModel->id]];
} else {
    $title = '';
}
$this->params['breadcrumbs'][] = Backend::getQuestionTitle($moduleModel);
?>
<div class="course-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('../elements/course_info', ['model' => $model]) ?>
    <h2><?= Html::encode($title.Backend::getQuestionTitle($moduleModel)) ?></h2>
    <p>
        <?= Html::a('Добавить вопрос', ['question-create?id='.($moduleModel ? $moduleModel['id'].'&type=module' : $model['id'])], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->title), Url::to(['question-update', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            ['label' => 'Ответы',
                'value' => function ($data) {
                    return Backend::getQuestionAnswerUl($data->id);
                },
                'format'=>'html',
            ],
            [
                'value' => function ($data)  {
                    return Html::a('Удалить', ['question-delete?id='.$data->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы действительно хотите удалить вопрос ('.$data->title.')?',
                        ],
                    ]);
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>

</div>
