<?php
declare(strict_types=1);

namespace XTags\Domain\Model\TagLabel\ValueObject;

use Assert\Assert;
use PcComponentes\Ddd\Domain\Model\ValueObject\StringValueObject;

class LabelName extends StringValueObject
{
    public function __construct(string $value)
    {
        Assert::lazy()
            ->that($value, 'label.name')->minLength(1)
            ->that($value, 'label.name')->notRegex(
                '/^\s/',
                'Name cannot begin with a whitespace',
            )
            ->that($value, 'label.name')->notRegex(
                '/\s$/',
                'Name cannot end with a whitespace',
            )
            ->verifyNow()
        ;

        parent::__construct($value);
    }

}
