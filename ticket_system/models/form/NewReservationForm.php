<?php

namespace app\models\form;

use app\enum\GenderEnum;
use app\enum\TicketTypeEnum;
use app\helper\TicketNumberGenerator;
use app\models\db\Reservation;
use app\models\db\Ticket;
use Yii;
use yii\base\Model;

class NewReservationForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var string
     */
    public $entranceDate;

    /**
     * @var int
     */
    public $ticketsCount;

    /**
     * @var int
     */
    private $normalTicketsCount;

    /**
     * @var int
     */
    private $seniorTicketsCount;

    /**
     * @var int
     */
    private $childTicketsCount;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => Yii::t('app', 'Email address is required')],
            ['email', 'string', 'min' => 7, 'max' => 64],
            ['name', 'required', 'message' => Yii::t('app', 'Customer is required')],
            ['name', 'string', ' min' => 3, 'max' => 64],
            ['ticketsCount', 'integer', 'min' => 1, 'max' => 6],
            ['phoneNumber', 'string', 'min' => 7, 'max' => 12],
            ['gender', 'string'],
            ['entranceDate', 'date'],
            ['ticketsCount', 'integer', 'min' => 1, 'max' => 6],
            ['normalTicketsCount', 'integer'],
            ['seniorTicketsCount', 'integer'],
            ['childTicketsCount', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function getAvailableGenders()
    {
        $availableGenders = GenderEnum::getList();
        $options = [];

        foreach ($availableGenders as $key => $gender) {
            $options[$key] = $gender;
        }

        return $options;
    }

    /**
     * @return bool
     */
    public function add()
    {
        if ($this->validate()) {
            $reservationNumber = TicketNumberGenerator::getNumber();

            $reservationRepository = new Reservation();
            $reservationRepository->reservation_number = $reservationNumber;
            $reservationNumber->entrance_date = $this->entranceDate;
            $reservationRepository->email = $this->email;
            $reservationRepository->name = $this->name;
            if (!empty($this->gender)) {
                $reservationRepository->gender = $this->gender;
            }
            if (!empty($this->phoneNumber)) {
                $reservationRepository->phone_number = $this->phoneNumber;
            }

            if ($reservationRepository->save()) {
                return $this->addTickets($reservationNumber);
            }

            return false;
        }

        return false;
    }

    /**
     * @param int $reservationNumber
     * @return bool
     */
    private function addTickets($reservationNumber)
    {
        for ($i = 0; $i < $this->normalTicketsCount; $i++) {
            if (!$this->addTicketsByType(TicketTypeEnum::ADULT, $reservationNumber)) {
                return false;
            }
        }

        for ($i = 0; $i < $this->seniorTicketsCount; $i++) {
            if (!$this->addTicketsByType(TicketTypeEnum::SENIOR, $reservationNumber)) {
                return false;
            }
        }

        for ($i = 0; $i < $this->childTicketsCount; $i++) {
            if (!$this->addTicketsByType(TicketTypeEnum::CHILD, $reservationNumber)) {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $ticketType
     * @param $reservationNumber
     * @return bool
     */
    private function addTicketsByType($ticketType, $reservationNumber)
    {
        $ticketRepository = new Ticket();
        $ticketRepository->ticket_type = $ticketType;
        $ticketRepository->reservation_number = $reservationNumber;
        return $ticketRepository->save();
    }
}