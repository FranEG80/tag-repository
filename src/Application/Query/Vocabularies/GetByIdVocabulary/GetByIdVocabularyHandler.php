<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByIdVocabulary;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Vocabularies\ByIdVocabulariesFinder;

class GetByIdVocabularyHandler
{
    private ByIdVocabulariesFinder $allVocabulariesFinder;

    public function __construct(
        ByIdVocabulariesFinder $allVocabulariesFinder,
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
        return ($this->allVocabulariesFinder)($query->id());
    }
}
