<?php

namespace app\controllers;

use app\models\TaskList;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'cors'  => [
                'class' => Cors::className(),
                'cors'  => [
                    'Origin' => ['*'],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionUpload($name)
    {
        $body = \Yii::$app->getRequest()->getRawBody();

        $is_new = false;
        $model = TaskList::findOne(['name' => $name]);
        if($model === null) {
            $model = new TaskList(['name' => $name]);
            $is_new = true;
        }
        $model->data = $body;
        $status = $model->save();

        return [
            'is_new' => $is_new,
            'status' => $status,
            'id' => $model->id,
            'name' => $model->name,
        ];
    }

    public function actionList()
    {
        $list = [];
        $models = TaskList::find()->all();
        foreach ($models as $model) {
            $list[] = [
                'id' => $model->id,
                'name' => $model->name,
            ];
        }

        return $list;
    }

    public function actionLoad($id)
    {
        $model = TaskList::findOne(['id' => $id]);
        if($model === null) {
            throw new NotFoundHttpException();
        }

        return [
            'id' => $model->id,
            'name' => $model->name,
            'data' => $model->data,
        ];
    }
}