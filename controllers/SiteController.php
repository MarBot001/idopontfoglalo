<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\web\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use app\models\Service;
use app\models\AvailableTime;
use app\models\LoginForm;
use app\models\Appointment;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'admin', 'view'],
                'rules' => [
                    [
                        'actions' => ['logout', 'admin', 'view'],
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
     * Displays homepage.
     *
     * @return string
     */

     public function actionIndex()
     {
         $model = new Appointment();
     
         $services = ArrayHelper::map(Service::find()->all(), 'name', 'name'); // név szerint
         $availableTimes = ArrayHelper::map(AvailableTime::find()->all(), 'time', 'time'); // idő szerint
     
         if ($model->load(Yii::$app->request->post())) {
             if ($model->validate() && $model->save()) {
                 Yii::$app->session->setFlash('success', 'Sikeres foglalás!');
                 return $this->redirect(['index']);
             } else {
                 $errors = $model->getFirstErrors();
                 Yii::$app->session->setFlash('error', reset($errors));
             }
         }
     
         return $this->render('index', [
             'model' => $model,
             'services' => $services,
             'availableTimes' => $availableTimes,
         ]);
     }

    public function actionGetEvents()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $appointments = Appointment::find()->all();
        $events = [];

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->time . ' - Foglalt!',
                'start' => $appointment->date . 'T' . $appointment->time,
            ];
        }

        return $events;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['admin/admin']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
