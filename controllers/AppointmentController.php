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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) { // Ha minden validáció sikeres
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Sikeresen foglaltál időpontot!');
                    return $this->redirect(['index']);
                }
            } else {
                // Validációs hibák esetén
                $errors = $model->getFirstErrors();
                $errorMessage = reset($errors); // Az első hibaüzenet
                Yii::$app->session->setFlash('error', $errorMessage);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
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
