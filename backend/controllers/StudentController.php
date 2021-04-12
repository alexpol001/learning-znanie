<?php

namespace backend\controllers;

use backend\components\Backend;
use backend\models\NewPasswordForm;
use common\models\StudentCourse;
use common\models\User;
use Yii;
use common\models\Student;
use common\models\Search\Student as StudentSearch;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use common\models\Search\StudentCourse as StudentCourseSearch;
use common\models\Search\Course as CourseSearch;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends AuthController
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
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
     * @param $id
     * @param null $is_archive
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $is_archive = null)
    {
        $model = $this->findModel($id);

        if (($model->load(Yii::$app->request->post()) && $model->save()) || $is_archive !== null) {
            if ($is_archive !== null) {
                $model->is_archive = $is_archive;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $student = $this->findModel($id);
        if ($student->userId0->status != User::STATUS_ADMIN) {
            $student->delete();
        }
        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionNewPassword($id)
    {
        $model = $this->findModel($id);
        $modelForm = new NewPasswordForm();

        if ($modelForm->load(Yii::$app->request->post())) {
            if ($student = $modelForm->changePassword(User::findByUserEmail($model->email))) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('new_password', [
            'model' => $model,
            'modelForm' => $modelForm,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCourse($id)
    {
        $model = $this->findModel($id);
        $searchModel = new StudentCourseSearch();
        $searchModel->studentId = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('course/index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @param null $course_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAddCourse($id, $course_id = null)
    {
        $model = $this->findModel($id);
        $searchModel = new CourseSearch();
        $searchModel->studentId = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($course_id) {
            if (Backend::activeCourse($id, $course_id))
                return $this->redirect(['course', 'id' => $id]);
        }

        return $this->render('course/add', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCourseView($id)
    {
        $courseModel = StudentCourse::findOne($id);
        $model = $this->findModel($courseModel->student_id);
        return $this->render('course/view', [
            'model' => $model,
            'courseModel' => $courseModel,
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDeleteCourse($id)
    {
        $courseModel = StudentCourse::findOne($id);
        $model = $this->findModel($courseModel->student_id);
        $courseModel->delete();
        return $this->redirect(['course', 'id' => $model->id]);
    }

    /**
     * @param $id
     * @return Student|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
