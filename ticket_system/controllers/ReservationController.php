<?php

namespace app\controllers;

use app\models\form\NewReservationForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ReservationController extends Controller
{
    /**
     * @return string|Response
     */
    public function actionNew()
    {
        $newReservationForm = new NewReservationForm();

        if ($newReservationForm->load(Yii::$app->request->post())) {
            if ($newReservationForm->add()) {
                Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Reservation has been created'));
                return $this->goHome();
            }
        }

        return $this->render('new');
    }
}