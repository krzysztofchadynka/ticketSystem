<?php

namespace app\models\db;

use yii\db\ActiveRecord;

/**
 * @property string $email
 * @property string $name
 * @property string $phone_number
 * @property string $gender
 * @property string $entrance_date
 * @property int $reservation_number
 */
class ReservationRepository extends ActiveRecord
{
}