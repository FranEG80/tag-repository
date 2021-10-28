<?php
declare(strict_types=1);

namespace XTags\Application\Query\Languages\GetByIdLanguage;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Languages\LanguagesCollection;
use XTags\Domain\Model\Languages\LanguagesRepository;
use XTags\Domain\Service\Languages\ByIdLanguagesFinder;

class GetByIdLanguageHandler
{

    private ByIdLanguagesFinder $languageFinder;

    public function __construct(
        ByIdLanguagesFinder $languageFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->languageFinder = $languageFinder;
    }

    /**
     * @return LanguagesCollection
     */
    public function __invoke(GetByIdLanguageQuery $query)
    {
        return ($this->languageFinder)($query->id());
    }
}
