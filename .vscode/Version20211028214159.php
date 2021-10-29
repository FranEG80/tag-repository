<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028214159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, vocabulary_id INT NOT NULL, definition_id INT NOT NULL, name VARCHAR(255) NOT NULL, version VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EA750E882F1BAF4 (language_id), INDEX IDX_EA750E8AD0E05F6 (vocabulary_id), INDEX IDX_EA750E8D11EA911 (definition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', external_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', external_system_id INT NOT NULL, version VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `schema` (id INT AUTO_INCREMENT NOT NULL, vocabulary_id INT NOT NULL, type VARCHAR(50) NOT NULL, schema_url VARCHAR(255) NOT NULL, relations_parse LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_B88E4152AD0E05F6 (vocabulary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', vocabulary_id INT NOT NULL, type_id INT NOT NULL, resource_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', definition_id INT NOT NULL, name VARCHAR(255) NOT NULL, version VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_389B783AD0E05F6 (vocabulary_id), INDEX IDX_389B783C54C8C93 (type_id), INDEX IDX_389B78389329D25 (resource_id), INDEX IDX_389B783D11EA911 (definition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vocabulary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, search_url VARCHAR(255) NOT NULL, definition_url VARCHAR(255) NOT NULL, version VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E8AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabulary (id)');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E8D11EA911 FOREIGN KEY (definition_id) REFERENCES definition (id)');
        $this->addSql('ALTER TABLE `schema` ADD CONSTRAINT FK_B88E4152AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabulary (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabulary (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B78389329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E8D11EA911');
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E882F1BAF4');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B78389329D25');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783C54C8C93');
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E8AD0E05F6');
        $this->addSql('ALTER TABLE `schema` DROP FOREIGN KEY FK_B88E4152AD0E05F6');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783AD0E05F6');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE `schema`');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE vocabulary');
    }
}
