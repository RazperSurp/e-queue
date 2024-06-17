<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\{Clients, EmployeesPositions};

class QueueController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionSign()
    {
        return $this->render('sign');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionRegister()
    {
        if ($_COOKIE['eqpk']) $this->redirect("position?token=". $_COOKIE['eqpk']);

        if (!Yii::$app->request->isPost) return $this->render('register', ['model' => new Clients()]);
        else return $this->render('position', Clients::addNew(Yii::$app->request->post()));
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionPosition($token)
    {
        list($id, $time) = explode('_', $token);
        return $this->render('position', ['id' => $id, 'time' => $time]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionCheck($token) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Clients::checkQueue($token);
    }
}
