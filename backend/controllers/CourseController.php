<?php

namespace backend\controllers;

use backend\components\Backend;
use common\components\Common;
use common\models\CourseModule;
use common\models\Question;
use common\models\QuestionAnswer;
use Yii;
use common\models\Course;
use common\models\Search\Course as CourseSearch;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use common\models\Search\CourseModule as CourseModuleSearch;
use yii\web\UploadedFile;
use common\models\Search\Question as QuestionSearch;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends AuthController
{

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Course();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $image = [];
        $imageDocument = [];
        if ($logo = $model->image) {
            $image[] = '<img src="' . Common::getUrlCourseLogo($logo) . '" style="width:auto;height:auto;max-width:100%;max-height:100%;"';
        }
        if ($document = $model->document) {
            $imageDocument[] = '<img src="' . Common::getUrlCourseDocument($document) . '" style="width:auto;height:auto;max-width:100%;max-height:100%;"';
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $image,
            'imageDocument' => $imageDocument
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionModule($id)
    {
        $model = $this->findModel($id);
        $searchModel = new CourseModuleSearch();
        $searchModel->courseId = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('module/index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionModuleCreate($id)
    {
        $model = $this->findModel($id);
        $moduleModel = new CourseModule();
        if ($moduleModel->load(Yii::$app->request->post()) && $moduleModel->save()) {
            return $this->redirect(['module-view', 'id' => $moduleModel->id]);
        }

        return $this->render('module/create', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionModuleView($id)
    {
        $moduleModel = CourseModule::findOne($id);
        $model = $this->findModel($moduleModel->course_id);

        return $this->render('module/view', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'files_add' => Backend::getModuleFiles($moduleModel),
        ]);
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function actionModuleUpload()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post("module_id");
            $path = Yii::getAlias("@course_module/" . $id);
            BaseFileHelper::createDirectory($path);
            $file = UploadedFile::getInstanceByName('materials');
            if ($file) {
                $name = $file->name;
                $name = Common::translit($name);
                $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function actionDeleteMaterial()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post("module_id");
            $file = Yii::$app->request->post('file');
            $path = Yii::getAlias("@course_module/" . $id . '/' . $file);
            if (file_exists($path)) {
                @unlink($path);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionModuleUpdate($id)
    {
        $moduleModel = CourseModule::findOne($id);
        $model = $this->findModel($moduleModel->course_id);

        if ($moduleModel->load(Yii::$app->request->post()) && $moduleModel->save()) {
            return $this->redirect(['module-view', 'id' => $moduleModel->id]);
        }

        return $this->render('module/update', [
            'model' => $model,
            'moduleModel' => $moduleModel
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionModuleDelete($id)
    {
        $moduleModel = CourseModule::findOne($id);
        $model = $this->findModel($moduleModel->course_id);
        $moduleModel->delete();
        return $this->redirect(['module', 'id' => $model->id]);
    }


    /**
     * @param $id
     * @param null $type
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionQuestion($id, $type = null)
    {
        switch ($type) {
            case 'module':
                $moduleModel = CourseModule::findOne($id);
                $model = $this->findModel($moduleModel->course_id);
                $searchModel = new QuestionSearch();
                $searchModel->moduleId = $id;
                break;
            default:
                $model = $this->findModel($id);
                $searchModel = new QuestionSearch();
                $searchModel->courseId = $id;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /** @var $moduleModel CourseModule */
        return $this->render('question/index', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @param null $type
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionQuestionCreate($id, $type = null)
    {
        switch ($type) {
            case 'module':
                $moduleModel = CourseModule::findOne($id);
                $model = $this->findModel($moduleModel->course_id);
                break;
            default:
                $model = $this->findModel($id);
        }
        /** @var $moduleModel CourseModule */
        $questionModel = new Question();
        if ($questionModel->load(Yii::$app->request->post()) && $questionModel->save()) {
            $questionAnswer = Yii::$app->request->post()['QuestionAnswer'];
            $right_i = 1;
            foreach ($questionAnswer['title'] as $key => $answer) {
                $answerModel = new QuestionAnswer();
                $answerModel->title = $answer;
                $is_right = 0;
                $answerModel->question_id = $questionModel->id;
                if ($questionAnswer['is_right'][$key + $right_i]) {
                    $is_right = 1;
                    $right_i++;
                }
                $answerModel->is_right = $is_right;
                $answerModel->save();
            }
            return $this->redirect(['question', 'id' => $moduleModel ? $moduleModel->id : $model->id, 'type' => $moduleModel ? 'module' : null]);
        }

        $answerModel = new QuestionAnswer();

        return $this->render('question/create', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'questionModel' => $questionModel,
            'answerModel' => $answerModel,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionQuestionUpdate($id)
    {
        $questionModel = Question::findOne($id);
        $moduleModel = $questionModel->moduleId0;
        $model = $moduleModel ? $moduleModel->courseId0 : $questionModel->courseId0;
        $answerModels = QuestionAnswer::findAll(['question_id' => $id]);
        if ($questionModel->load(Yii::$app->request->post()) && $questionModel->save()) {
            QuestionAnswer::deleteAll(['question_id' => $questionModel->id]);
            $questionAnswer = Yii::$app->request->post()['QuestionAnswer'];
            $right_i = 1;
            foreach ($questionAnswer['title'] as $key => $answer) {
                $answerModel = new QuestionAnswer();
                $answerModel->title = $answer;
                $is_right = 0;
                $answerModel->question_id = $questionModel->id;
                if ($questionAnswer['is_right'][$key + $right_i]) {
                    $is_right = 1;
                    $right_i++;
                }
                $answerModel->is_right = $is_right;
                $answerModel->save();
            }
            return $this->redirect(['question', 'id' => $moduleModel ? $moduleModel->id : $model->id, 'type' => $moduleModel ? 'module' : null]);
        }

        $answerModel = new QuestionAnswer();

        return $this->render('question/update', [
            'model' => $model,
            'moduleModel' => $moduleModel,
            'questionModel' => $questionModel,
            'answerModel' => $answerModel,
            'answerModels' => $answerModels,
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionQuestionDelete($id)
    {
        $questionModel = Question::findOne($id);
        $moduleModel = $questionModel->moduleId0;
        $model = $moduleModel ? $moduleModel->courseId0 : $questionModel->courseId0;
        $questionModel->delete();

        return $this->redirect(['question', 'id' => $moduleModel ? $moduleModel->id : $model->id, 'type' => $moduleModel ? 'module' : null]);
    }


    /**
     * @param $id
     * @return Course|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
