<?php
namespace app\models;

use yii\db\ActiveRecord;

class AvailableTime extends ActiveRecord
{
    public static function tableName()
    {
        return 'available_times';
    }
}
