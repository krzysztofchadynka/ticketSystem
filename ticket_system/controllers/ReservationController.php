<?php

namespace app\controllers;

use yii\web\Controller;

class ReservationController extends Controller
{
    public function actionNew_reservation()
    {
        return $this->render('new_reservation');
    }
}