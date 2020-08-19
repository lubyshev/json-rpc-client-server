<?php
declare(strict_types=1);

namespace common\models;

use common\models\fields\FormTypeField;
use yii\db\ActiveRecord;

/**
 * Class Form
 *
 * @package backend\models
 *
 * @property integer                     $id
 * @property string                      $uuid
 * @property string|FormTypeField        $formType
 * @property ?string|?\DateTimeImmutable $createdAt
 */
class Form extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%forms}}';
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->formType  = new FormTypeField($this->formType);
        $this->createdAt = new \DateTimeImmutable($this->createdAt);
    }

    public function beforeSave($insert)
    {
        $this->formType = $this->formType->getValue();
        if ($this->createdAt) {
            $this->createdAt = $this->createdAt->format('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public function init()
    {
        parent::init();
        if (null === $this->formType) {
            $this->formType = new FormTypeField();
        }
    }

}
