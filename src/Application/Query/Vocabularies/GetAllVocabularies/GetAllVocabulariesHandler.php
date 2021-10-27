<?php

namespace XTags\Application\Query\Vocabularies\GetAllVocabularies;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Vocabularies\VocabulariesCollection;
use XTags\Domain\Service\Vocabularies\AllVocabulariesFinder;

class GetAllVocabulariesHandler
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
    public function __invoke(GetAllVocabulariesQuery $query)
    {
        $vocabularies = [];
        $vocabularies[] = ($this->allVocabulariesFinder)();
        return $vocabularies;
    }
}
