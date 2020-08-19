<?php
declare(strict_types=1);

namespace common\models\fields;

use yii\base\InvalidArgumentException;

class FormTypeField
{
    public const TYPE_AUTHOR = 'author';
    public const TYPE_BOOK   = 'book';

    private const TYPES = [
        self::TYPE_AUTHOR,
        self::TYPE_BOOK,
    ];

    private ?string $value;

    public function __construct(?string $formType = null)
    {
        $this->setValue($formType);
    }

    public function setValue(?string $formType): self
    {
        if ($formType && !in_array($formType, self::TYPES)) {
            throw new InvalidArgumentException("Invalid FormType: `$formType`");
        }
        $this->value = $formType;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

}
