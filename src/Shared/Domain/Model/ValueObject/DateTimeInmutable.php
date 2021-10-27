<?php
declare(strict_types=1);

namespace XTags\Shared\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;

class DateTimeInmutable extends DateTimeValueObject
{

    final public static function fromAnotherDateTime(\DateTimeImmutable $dateTimeInmutable): self
    {
        $output = new static();
        $output->setTimestamp($dateTimeInmutable->getTimestamp());
        $output->setTimezone($dateTimeInmutable->getTimezone());

        return $output;
    }

}
