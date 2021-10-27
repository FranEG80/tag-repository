<?php
declare(strict_types=1);

namespace XTags\Application\Query\Vocabularies\GetByNameVocabulary;

use Symfony\Component\Messenger\MessageBusInterface;
use XTags\Domain\Service\Vocabularies\ByNameVocabularyFinder;

class GetByNameVocabularyHandler
{
    private ByNameVocabularyFinder $allVocabulariesFinder;

    public function __construct(
        ByNameVocabularyFinder $allVocabulariesFinder,
        MessageBusInterface $eventBus
    )
    {
        $this->allVocabulariesFinder = $allVocabulariesFinder;
    }

    /**
     * @return VocabulariesCollection
     */
    public function __invoke(GetByNameVocabularyQuery $query)
    {
        return  ($this->allVocabulariesFinder)($query->name(), $query->version());
    }
}
