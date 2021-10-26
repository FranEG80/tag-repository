<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Types\ValueObject;

use Assert\Assert;
use PcComponentes\Ddd\Domain\Model\ValueObject\StringValueObject;

class TypesName extends StringValueObject
{
    public function __construct(string $value)
    {
        Assert::lazy()
            ->that($value, 'type.name')->minLength(1)
            ->that($value, 'type.name')->notRegex(
                '/^\s/',
                'Name cannot begin with a whitespace',
            )
            ->that($value, 'type.name')->notRegex(
                '/\s$/',
                'Name cannot end with a whitespace',
            )
            ->verifyNow()
        ;

        parent::__construct($value);
    }

}
