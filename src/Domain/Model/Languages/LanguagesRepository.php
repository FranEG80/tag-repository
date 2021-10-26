<?php
declare(strict_types=1); 

namespace XTags\Domain\Model\Languages;

use XTags\Domain\Model\Languages\ValueObject\LanguagesId;

interface LanguagesRepository
{
    public function save(Languages $language): void;

    public function find(LanguagesId $languageId): ?Languages;

    public function findAll(): LanguagesCollection;
}