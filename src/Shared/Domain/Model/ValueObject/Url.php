<?php

namespace XTags\Shared\Domain\Model\ValueObject;

use Assert\Assert;
use PcComponentes\Ddd\Domain\Model\ValueObject\StringValueObject;

class Url extends StringValueObject
{
    protected function __construct(string $value)
    {
        // TODO Implements regex url
        Assert::lazy()
            ->that($value)->minLength(1)
            ->that($value)->notRegex(
                '/^\s/',
                'Name cannot begin with a whitespace',
            )
            ->that($value)->notRegex(
                '/\s$/',
                'Name cannot end with a whitespace',
            )
            ->verifyNow()
        ;

        parent::__construct($value);
    }
}
