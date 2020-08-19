<?php
declare(strict_types=1);

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 *
 * @package backend\models
 *
 * @property integer $id
 * @property string  $uuid
 * @property string  $title
 * @property string  $review
 */
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%books}}';
    }

}
