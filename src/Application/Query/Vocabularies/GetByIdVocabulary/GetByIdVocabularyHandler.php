<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByIdVocabulary;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Vocabularies\ByIdVocabulariesFinder;

class GetByIdVocabularyHandler
{
    private ByIdVocabulariesFinder $byIdVocabularyFinder;

    public function __construct(
        ByIdVocabulariesFinder $byIdVocabularyFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->byIdVocabularyFinder = $byIdVocabularyFinder;
    }

    /**
     * @return VocabulariesCollection
     */
    public function __invoke(GetByIdVocabularyQuery $query)
    {
        return ($this->byIdVocabularyFinder)($query->id());
    }
}
