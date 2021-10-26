<?php
declare(strict_types=1);

namespace XTags\Shared\Domain;

use PcComponentes\TopicGenerator\Company;

final class CompanyName extends Company
{

    private const COMPANY_NAME = 'ximdex';

    public function name(): string
    {
        return self::COMPANY_NAME;
    }
}
