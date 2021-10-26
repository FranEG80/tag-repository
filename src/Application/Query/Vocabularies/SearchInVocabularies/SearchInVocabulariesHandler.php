<?php

namespace XTags\Application\Query\Vocabularies\SearchInVocabularies;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Model\Vocabularies\VocabulariesRepository;

class SearchInVocabulariesHandler
{
    private VocabulariesRepository $vocabulariesRepository;

    public function __construct(VocabulariesRepository $vocabulariesRepository, MessageBusInterface $eventBus)
    {
        $this->vocabulariesRepository = $vocabulariesRepository;
    }

    public function __invoke(SearchInVocabulariesQuery $query): array
    {
        return $this->vocabulariesRepository->searchQuery(
            $query->vocabulary(),
            $query->mode(),
            $query->query(),
            $query->langsearch(),
            $query->langlabel(),
            $query->suggestions(),
            $query->tag_id()
        );
    }
}
