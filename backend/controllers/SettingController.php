<?php

namespace backend\controllers;


use common\models\Setting;
use Yii;
use yii\web\NotFoundHttpException;

class SettingController extends AuthController
{
    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = $this->findSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash("success", "Изменения были успешно сохранены.");
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return Setting|null
     * @throws NotFoundHttpException
     */
    protected function findSetting()
    {
        if (($model = Setting::getSetting()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
