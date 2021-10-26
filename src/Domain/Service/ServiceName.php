<?php
declare(strict_types=1);

namespace XTags\Domain\Service;

use PcComponentes\TopicGenerator\Service;

final class ServiceName extends Service
{
    
    private const SERVICE_NAME = 'xtags';

    public function name(): string
    {
        return self::SERVICE_NAME;
    }
}
