<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029021745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial values (Languages, Vocabularies and Types)';
    }

    public function up(Schema $schema): void
    {
        $this->addVocabularies();
        $this->addLanguages();
        $this->addTypes();
    }

    public function addVocabularies(): void
    {
        $sep = ", ";

        $sql = "INSERT INTO `vocabulary` ( `name`, `url`, `search_url`, `definition_url`, `version`, `created_at`, `updated_at`) VALUES ";
       
        // Thesauro Vocabulary
        $thesaurus = "(";
        $thesaurus .= "'Thesauro - Unesco'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/thesaurus/'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/search?vocab=thesaurus&query=%%ximdex_query%%*&lang=%%ximdex_lang%%&labellang=%%ximdex_labellang%%'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/thesaurus/data?uri=http%3A%2F%2Fvocabularies.unesco.org%2Fthesaurus%2Fconcept%%ximdex_tag_id%%&format=application/%%ximdex_schema%%'";
        $thesaurus .= $sep . "1";
        $thesaurus .= $sep . "NOW()";
        $thesaurus .= $sep . "NOW()";
        $thesaurus .= ")";

        $this->addSql($sql . $thesaurus);
    }

    private function addLanguages(): void
    {
        $this->addSql("INSERT INTO `language` (`name`) VALUES ('es-ES'), ('en-GB')");
    }


    private function addTypes(): void
    {
        $sql = "INSERT INTO `type` ( `name`) VALUES ";
        $sql .= "('Custom')";
        
        $this->addSql($sql);
    }
}
