<?php

namespace XTags\Application\Query\Languages\GetAllLanguages;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Application\Query\Languages\GetAllLanguages\GetAllLanguagesQuery;
use XTags\Domain\Model\Languages\LanguagesCollection;
use XTags\Domain\Model\Languages\LanguagesRepository;
use XTags\Domain\Service\Languages\AllLanguagesFinder;

class GetAllLanguagesHandler
{

    private AllLanguagesFinder $allLanguagesFinder;

    public function __construct(
        AllLanguagesFinder $allLanguagesFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allLanguagesFinder = $allLanguagesFinder;
    }

    /**
     * @return LanguagesCollection
     */
    public function __invoke(GetAllLanguagesQuery $query)
    {
        $languages = [];
        $languages[] = ($this->allLanguagesFinder)();
        return $languages;
    }
}
