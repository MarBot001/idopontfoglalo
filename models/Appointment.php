<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\AvailableTime;

class Appointment extends ActiveRecord
{
    public static function tableName()
    {
        return 'appointments';
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'A név megadása kötelező!'],
            ['date', 'required', 'message' => 'Kérem, válasszon egy időpontot!'],
            ['time', 'required', 'message' => ''],
            ['service', 'required', 'message' => 'Válasszon egy szolgáltatást!'],
            ['email', 'required', 'message' => 'Kérem, adja meg az email címét.'],
            ['phone', 'required', 'message' => 'Kérem, adja meg a telefonszámát!.'],
            [['name', 'email', 'phone'], 'trim'],

            [['name', 'date', 'time', 'service'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['name', 'email', 'phone', 'service'], 'string', 'max' => 255],
            [['comments'], 'string'],
            [['email'], 'email'],
            ['time', 'validateTimeFromDb'],
            ['time', 'validateFutureTime'],
            ['date', 'validateDate'],
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
            if (self::find()->where(['date' => $this->date, 'time' => $this->time])->exists()) {
                $this->addError('time', 'Erre az időpontra már van foglalás.');
                return false;
            }

            // HH:mm → HH:mm:ss konverzió
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
    }

    public function validateTimeFromDb($attribute)
    {
        $validTimes = ArrayHelper::getColumn(AvailableTime::find()->all(), 'time');
        if (!in_array($this->$attribute, $validTimes)) {
            $this->addError($attribute, 'Csak az adatbázisban rögzített időpontokra foglalhatsz.');
        }
    }
}
