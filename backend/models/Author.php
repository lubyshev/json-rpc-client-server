<?php
declare(strict_types=1);

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * Class Author
 *
 * @package backend\models
 *
 * @property integer $id
 * @property string  $uuid
 * @property string  $name
 * @property string  $lastName
 * @property string  $middleName
 * @property string  $biography
 */
class Author extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%authors}}';
    }

}
