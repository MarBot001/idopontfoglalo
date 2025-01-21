<?php

namespace app\models;

use yii\db\ActiveRecord;

class Appointment extends ActiveRecord
{
    public static function tableName()
    {
        return 'appointments';
    }

    public function rules()
    {
        return [
            [['name', 'date', 'time'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['time'], 'in', 'range' => [
                '08:00',
                '08:30',
                '09:00',
                '09:30',
                '10:00',
                '10:30',
                '11:00',
                '11:30',
                '12:00',
                '12:30',
                '13:00',
                '13:30',
                '14:00',
                '14:30',
                '15:00',
                '15:30'
            ], 'message' => 'Csak félórás időpontokat választhatsz.'],
            ['time', 'validateFutureTime'], // Egyedi validáció
            [['date'], 'validateDate'],
        ];
    }

    public function validateFutureTime($attribute, $params)
    {
        $selectedDateTime = strtotime($this->date . ' ' . $this->time);
        $currentDateTime = time();

        if ($selectedDateTime < $currentDateTime) {
            $this->addError($attribute, 'Nem foglalhatsz az aktuális idő előtti időpontra.');
        }
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Ellenőrizzük, hogy van-e már foglalás ugyanerre az időpontra
            if (self::find()->where(['date' => $this->date, 'time' => $this->time])->exists()) {
                $this->addError('time', 'Erre az időpontra már van foglalás.');
                return false;
            }

            // Konvertáljuk a HH:mm formátumot HH:mm:ss formátumra
            if ($this->time && !str_contains($this->time, ':00')) {
                $this->time .= ':00';
            }

            return true;
        }
        return false;
    }

    public function validateDate($attribute, $params)
    {
        $date = strtotime($this->date);
        $dayOfWeek = date('N', $date); // 1 = hétfő, 7 = vasárnap

        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            $this->addError($attribute, 'Hétvégére nem lehet időpontot foglalni.');
        }

        $currentDate = strtotime(date('Y-m-d'));
        $maxDate = strtotime('+7 weekdays', $currentDate);

        if ($date > $maxDate) {
            $this->addError($attribute, 'Csak 7 munkanappal előre lehet időpontot foglalni.');
        }
    }
}
