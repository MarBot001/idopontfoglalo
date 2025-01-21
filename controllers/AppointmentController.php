<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Appointment;

class AppointmentController extends Controller
{
    public function actionIndex()
    {
        $model = new Appointment();

        // Ha POST kérés érkezik, próbáljuk meg menteni a foglalást
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sikeres foglalás!');
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }   


    public function actionCreate()
    {
        $model = new Appointment();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionGetEvents()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $appointments = Appointment::find()->all();
        $events = [];

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->time . ' - Foglalt!',
                'start' => $appointment->date . 'T' . $appointment->time,
            ];
        }

        return $events;
    }

   
    public function actionAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $appointments = Appointment::find()
        ->orderBy(['date' => SORT_DESC, 'time' => SORT_DESC])
        ->all();

        return $this->render('admin', [
            'appointments' => $appointments,
        ]);
    }
    public function actionDelete($id)
{
    $appointment = Appointment::findOne($id);
    if ($appointment !== null) {
        $appointment->delete();
        Yii::$app->session->setFlash('success', 'Foglalás sikeresen törölve.');
    } else {
        Yii::$app->session->setFlash('error', 'A foglalás nem található.');
    }

    return $this->redirect(['admin']);
}

}
