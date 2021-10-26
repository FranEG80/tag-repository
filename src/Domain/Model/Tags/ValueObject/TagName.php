<?php
declare(strict_types=1);

namespace XTags\Domain\Model\TagLabel\ValueObject;

use Assert\Assert;
use PcComponentes\Ddd\Domain\Model\ValueObject\StringValueObject;

class TagName extends StringValueObject
{
    public function __construct(string $value)
    {
        Assert::lazy()
            ->that($value, 'tag.name')->minLength(5)
            ->that($value, 'tag.name')->notRegex(
                '/^\s/',
                'Name cannot begin with a whitespace',
            )
            ->that($value, 'tag.name')->notRegex(
                '/\s$/',
                'Name cannot end with a whitespace',
            )
            ->verifyNow()
        ;

        parent::__construct($value);
    }

}
