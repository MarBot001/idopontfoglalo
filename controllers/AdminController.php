<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Appointment;

class AdminController extends Controller
{

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
    
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
    
        $appointment = Appointment::findOne($id);
    
        if (!$appointment) {
            throw new \yii\web\NotFoundHttpException('A foglalás nem található.');
        }
    
        return $this->render('view', [
            'appointment' => $appointment,
        ]);
    }
    

    public function actionDelete($id)
    {
        $appointment = Appointment::findOne($id);
        if ($appointment !== null) {
            $appointment->delete();
        } else {
            Yii::$app->session->setFlash('error', 'A foglalás nem található.');
        }

        return $this->redirect(['admin']);
    }
}
