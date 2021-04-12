<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\CourseModule;
use common\models\LoginForm;
use common\models\Student;
use common\models\StudentCourse;
use common\models\StudentCourseQuestion;
use common\models\StudentForm;
use common\components\Common;
use common\models\User;
use frontend\components\Frontend;
use Yii;

class DefaultController extends \yii\web\Controller
{
    public $layout = 'default';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'common\components\NumericCaptcha',
                'width' => '80',
                'height' => '34',
                'testLimit' => '1',
                'padding' => '5',
                'foreColor' => 0x000000,
                'backColor' => 0xffb022,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param string $type
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCourses($type = '')
    {
        $title = Common::getCoursesTypeTitle($type);

        $type = Frontend::getCourseType($title);
        $studentCourses = StudentCourse::getStudentCourseByStudentAndType(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $type);
        $courses = Course::getCourseByTypeAndOutStudentCourse($type, $studentCourses);
        return $this->render('courses', [
            'courses' => $courses,
            'title' => $title,
            'studentCourses' => $studentCourses,
        ]);
    }

    /**
     * @param $slug
     * @return bool|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCourse($slug)
    {
        $model = Course::findModelBySlug($slug);
        $isGuest = Yii::$app->user->isGuest;
        $courseModules = CourseModule::getCourseModulesByCourseId($model->id);
        $studentCourse = StudentCourse::getStudentCourseByStudentAndCourse(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $model->id);

        if ($studentCourse) {
            Frontend::checkHours($studentCourse);
            if ($studentCourse->status) {
                return $this->redirect(['course-result', 'slug' => $slug]);
            }
        }

        return $this->render('course', [
            'model' => $model,
            'isGuest' => $isGuest,
            'courseModules' => $courseModules,
            'studentCourse' => $studentCourse,
        ]);
    }


    /**
     * @param $slug
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionModuleTest($id)
    {
        $courseModule = CourseModule::findOne($id);
        $model = $courseModule->courseId0;
        $studentCourse = StudentCourse::getStudentCourseByStudentAndCourse(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $model->id);
        $countQuestions = count($courseModule->questions);


        if (!$studentCourse || !$countQuestions) {
            return $this->redirect(['course', 'slug' => $model->slug]);
        }
        StudentCourseQuestion::setQuestion(Yii::$app->request->post(), $studentCourse, $courseModule);
        $question = Frontend::getQuestion($studentCourse, $courseModule);
        if (!$question) {
            return $this->redirect(['test-result', 'id' => $id]);
        }

        $isOneAnswer = Frontend::isOneAnswer($question);
        $numberQuestion = Frontend::getNumberQuestion($question);

        return $this->render('test', [
            'studentCourse' => $studentCourse,
            'question' => $question,
            'isOneAnswer' => $isOneAnswer,
            'countQuestions' => $countQuestions,
            'numberQuestion' => $numberQuestion,
            'courseModule' => $courseModule,
        ]);
    }

    public function actionTestResult($id)
    {
        $courseModule = CourseModule::findOne($id);
        $model = $courseModule->courseId0;
        $studentCourse = StudentCourse::getStudentCourseByStudentAndCourse(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $model->id);
        $countQuestions = count($courseModule->questions);
        if (!$studentCourse || count($studentCourse->getStudentCourseTestQuestions($courseModule)) < $countQuestions) {
            return $this->redirect(['course', 'slug' => $model->slug]);
        }

        return $this->render('test_result', [
            'studentCourse' => $studentCourse,
            'courseModule' => $courseModule,
            'result' => Frontend::getResultTest($studentCourse, $courseModule),
        ]);
    }

    /**
     * @param $slug
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionExamine($slug)
    {
        $model = Course::findModelBySlug($slug);
        $studentCourse = StudentCourse::getStudentCourseByStudentAndCourse(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $model->id);
        $countQuestions = count($studentCourse->courseId0->questions);

        if (!$studentCourse || !$countQuestions || !$studentCourse->isModulesComplete() || $isWait = $studentCourse->isWait()) {
            if ($isWait) {
                \Yii::$app->session->setFlash("success", "Вы уже проходили данный экзамен! Следующее прохождение будет доступно через ".Frontend::plural_form($isWait, ['Минуту', 'Минуты', 'Минут']));
            } else if (!$studentCourse->isModulesComplete()) {
                \Yii::$app->session->setFlash("danger", "Вы можете приступить к сдаче экзамена, только после прохождения всех модулей");
            }
            return $this->redirect(['course', 'slug' => $slug]);
        }
        Frontend::checkHours($studentCourse);
        StudentCourseQuestion::setQuestion(Yii::$app->request->post(), $studentCourse);
        $question = Frontend::getQuestion($studentCourse);
        if (!$studentCourse->startCourse() || $studentCourse->status || !$question) {
            return $this->redirect(['course-result', 'slug' => $slug]);
        }

        $isOneAnswer = Frontend::isOneAnswer($question);
        $numberQuestion = Frontend::getNumberQuestion($question);

        return $this->render('test', [
            'studentCourse' => $studentCourse,
            'question' => $question,
            'isOneAnswer' => $isOneAnswer,
            'countQuestions' => $countQuestions,
            'numberQuestion' => $numberQuestion,
        ]);
    }

    /**
     * @param $slug
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCourseResult($slug)
    {
        $model = Course::findModelBySlug($slug);

        $studentCourse = StudentCourse::getStudentCourseByStudentAndCourse(Student::findByStudentEmail(User::getEmailById(Yii::$app->user->id)), $model->id);

        if (!$studentCourse || (!count($studentCourse->studentCourseExamineQuestions) && !$studentCourse->status)) {
            return $this->redirect(['course', 'slug' => $slug]);
        }
        $errors = null;
        if (!$studentCourse->status) {
            $result = Frontend::getResultExamine($studentCourse);
            $errors = $studentCourse->toResult($result);
        } else {
            $result = Frontend::getResultCourse($studentCourse);
        }

        return $this->render('course_result', [
            'studentCourse' => $studentCourse,
            'result' => $result,
            'isTime' => Common::getLastHours($studentCourse) ? 1 : 0,
            'errors' => $errors,
        ]);
    }

    /**
     * @param null $type
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRegistration($type = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new StudentForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($student = $model->createStudent()) {
                \Yii::$app->session->setFlash("success", "Вы успешно зарегистрированы! В скором времени мы вышлим вам пароль от вашей учетной записи.");
                return $this->goHome();
            }
        }

        return $this->render('registration', [
            'model' => $model,
            'isOrganization' => $type ? 1 : 0,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionFaq() {
        return $this->render('faq');
    }
}
