<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTimeImmutable;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022104202 extends AbstractMigration
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

    public function down(Schema $schema): void
    {
    }

    public function addVocabularies(): void
    {
        $sep = ", ";

        $sql = "INSERT INTO `vocabularies` (`name`, `url_vocabulary`, `url_definitions`, `created_at`, `update_at`, `version`, `url_search`) VALUES ";
       
        // Thesauro Vocabulary
        $thesaurus = "(";
        $thesaurus .= "'Thesauro - Unesco'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/thesaurus/'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/thesaurus/data?uri=http%3A%2F%2Fvocabularies.unesco.org%2Fthesaurus%2Fconcept%%ximdex_tag_id%%&format=application/%%ximdex_schema%%'";
        $thesaurus .= $sep . "NOW()";
        $thesaurus .= $sep . "NOW()";
        $thesaurus .= $sep . "'1'";
        $thesaurus .= $sep . "'http://vocabularies.unesco.org/browser/rest/v1/search?vocab=thesaurus&query=%%ximdex_query%%*&lang=%%ximdex_lang%%&labellang=%%ximdex_labellang%%'";
        $thesaurus .= ")";

        $this->addSql($sql . $thesaurus);
    }

    private function addLanguages(): void
    {
        $this->addSql("INSERT INTO `languages` (`name`) VALUES ('es-ES'), ('en-GB')");
    }


    private function addTypes(): void
    {
        $sql = "INSERT INTO `types` ( `name`, `created_at`, `update_at`, `version`) VALUES ";
        $sql .= "('Custom', NOW(), NOW(), '1')";
        $sql .= ", ";
        $sql .= "('Person', NOW(), NOW(), '1')";

        $this->addSql($sql);
    }
}
