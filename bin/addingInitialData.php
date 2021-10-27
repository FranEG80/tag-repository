<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class addingInitialData extends AbstractMigration
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

        //(NULL, 'Thesauro - Unesco', 'http://vocabularies.unesco.org/browser/thesaurus/', 'http://vocabularies.unesco.org/browser/rest/v1/search?vocab=thesaurus&query=%%ximdex_query%%*&lang=%%ximdex_lang%%&labellang=%%ximdex_labellang%%', 'http://vocabularies.unesco.org/browser/rest/v1/thesaurus/data?uri=http%3A%2F%2Fvocabularies.unesco.org%2Fthesaurus%2Fconcept%%ximdex_tag_id%%&format=application/%%ximdex_schema%%', '1', '2021-10-26 13:12:31.000000', '2021-10-26 13:12:31.000000');


        $sql = "INSERT INTO `vocabulary` (`id`, `name`, `url`, `search_url`, `definition_url`, `version`, `created_at`, `updated_at`) VALUES ";
       
        // Thesauro Vocabulary
        $thesaurus = "(";
        $thesaurus .= "'Thesauro - Unesco'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/thesaurus/'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/search?vocab=thesaurus&query=%%ximdex_query%%*&lang=%%ximdex_lang%%&labellang=%%ximdex_labellang%%'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/thesaurus/data?uri=http%3A%2F%2Fvocabularies.unesco.org%2Fthesaurus%2Fconcept%%ximdex_tag_id%%&format=application/%%ximdex_schema%%'";
        $thesaurus .= $sep . "'1'";
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
        $sql = "INSERT INTO `types` ( `name`, `created_at`, `update_at`, `version`) VALUES ";
        $sql .= "('Custom', NOW(), NOW(), '1')";

        $this->addSql($sql);
    }

}
