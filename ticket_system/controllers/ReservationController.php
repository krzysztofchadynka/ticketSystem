<?php

namespace app\controllers;

use app\models\form\NewReservationForm;
use app\models\form\NewTicketForm;
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
            $params = $newReservationForm->add();

            if (!empty($newReservationForm)) {
                return $this->redirect(
                    'book_tickets?reservationNumber=' . $params['reservationNumber'] . '&ticketsCount' . $params['ticketsCount']
                );
            }
        }

        return $this->render('new');
    }

    /**
     * @param int $reservationNumber
     * @param int $ticketsCount
     * @return string
     */
    public function actionBook_tickets($reservationNumber, $ticketsCount)
    {
        /** TODO: save currentNumber as cookie
         * Now for example only one ticket
         */

        $newTicketForm = new NewTicketForm();
        $number = 0;
        if ($newTicketForm->load(Yii::$app->request->post())) {
            $number++; // only for example - this has to be get from cache

            if ($newTicketForm->add($reservationNumber)) {
                return $this->render('book_tickets', ['number' => $number]);
            }
        }

        return $this->redirect('new');
    }
}