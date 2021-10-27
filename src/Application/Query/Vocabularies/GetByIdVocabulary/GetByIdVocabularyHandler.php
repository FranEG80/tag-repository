<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByIdVocabulary;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Vocabularies\AllVocabulariesFinder;

class GetByIdVocabularyHandler
{
    private AllVocabulariesFinder $allVocabulariesFinder;

    public function __construct(
        AllVocabulariesFinder $allVocabulariesFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allVocabulariesFinder = $allVocabulariesFinder;
    }

    /**
     * @return VocabulariesCollection
     */
    public function __invoke(GetByIdVocabularyQuery $query)
    {
        $vocabularies = [];
        $vocabularies[] = ($this->allVocabulariesFinder)();
        return $vocabularies;
    }
}
