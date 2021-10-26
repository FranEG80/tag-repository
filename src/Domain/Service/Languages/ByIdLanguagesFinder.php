<?php
declare(strict_types=1);

namespace XTags\Domain\Service\Languages;

use XTags\Domain\Model\Languages\Languages;
use XTags\Domain\Model\Languages\LanguagesRepository;
use XTags\Domain\Model\Languages\Exception\LanguagesDoesNotExistException;
use XTags\Domain\Model\Languages\ValueObject\LanguagesId;
use XTags\Infrastructure\Exceptions\Api\LanguagesResource;

class ByIdLanguagesFinder
{
    private LanguagesRepository $languagesRepository;

    public function __construct(LanguagesRepository $languagesRepository)
    {
        $this->languagesRepository = $languagesRepository;
    }

    public function __invoke(LanguagesId $languagesId): Languages
    {
        $languages = $this->languagesRepository->find($languagesId);

        if (null === $languages) {
            throw new LanguagesDoesNotExistException(LanguagesResource::create());
        }

        return $languages;
    }
}
