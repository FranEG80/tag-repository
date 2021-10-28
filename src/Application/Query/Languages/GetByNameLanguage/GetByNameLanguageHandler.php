<?php
declare(strict_types=1);

namespace XTags\Application\Query\Languages\GetByNameLanguage;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Languages\LanguagesCollection;
use XTags\Domain\Model\Languages\LanguagesRepository;
use XTags\Domain\Service\Languages\ByNameLanguageFinder;

class GetByNameLanguageHandler
{

    private ByNameLanguageFinder $languageFinder;

    public function __construct(
        ByNameLanguageFinder $languageFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->languageFinder = $languageFinder;
    }

    /**
     * @return LanguagesCollection
     */
    public function __invoke(GetByNameLanguageQuery $query)
    {
        return ($this->languageFinder)($query->id());
    }
}
