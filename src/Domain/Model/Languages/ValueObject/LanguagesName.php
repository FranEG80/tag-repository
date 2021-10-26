<?php
declare(strict_types=1);

namespace XTags\Domain\Model\Languages\ValueObject;

use Assert\Assert;
use PcComponentes\Ddd\Domain\Model\ValueObject\StringValueObject;

class LanguagesName extends StringValueObject
{
    public function __construct(string $value)
    {
        Assert::lazy()
            ->that($value, 'language.name')->minLength(5)
            ->that($value, 'language.name')->notRegex(
                '/^\s/',
                'Name cannot begin with a whitespace',
            )
            ->that($value, 'language.name')->notRegex(
                '/\s$/',
                'Name cannot end with a whitespace',
            )
            ->that($value, 'language.name')->regex(
                '/[a-z]{2}-[A-Z]{2}$/',
                "Name can only contain, 2 lowercase letters, one '-' and 2 uppercase letters."
            )
            ->verifyNow()
        ;

        parent::__construct($value);
    }

}
