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

    public function validateTimeFromDb($attribute)
    {
        $validTimes = ArrayHelper::getColumn(AvailableTime::find()->all(), 'time');
        if (!in_array($this->$attribute, $validTimes)) {
            $this->addError($attribute, 'Csak az adatbázisban rögzített időpontokra foglalhatsz.');
        }
    }
}
