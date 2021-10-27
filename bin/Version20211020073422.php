<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020073422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    { 
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_tags (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tags_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', resource_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', version INT NOT NULL, UNIQUE INDEX UNIQ_609C349C89329D25 (resource_id), INDEX IDX_609C349C8D7B4FB4 (tags_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_label (id INT AUTO_INCREMENT NOT NULL, lang_id INT NOT NULL, tags_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, version INT NOT NULL, INDEX IDX_2C4B49EEB213FA4 (lang_id), INDEX IDX_2C4B49EE8D7B4FB4 (tags_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', vocabulary_id INT NOT NULL, type_id INT DEFAULT NULL, custom_name VARCHAR(255) DEFAULT NULL, tag_label_id VARCHAR(255) NOT NULL, version INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6FBC9426AD0E05F6 (vocabulary_id), INDEX IDX_6FBC9426C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', version INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vocabularies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url_vocabulary VARCHAR(255) NOT NULL, url_definitions VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', version INT NOT NULL, url_search VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resource_tags ADD CONSTRAINT FK_609C349C8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE tag_label ADD CONSTRAINT FK_2C4B49EEB213FA4 FOREIGN KEY (lang_id) REFERENCES languages (id)');
        $this->addSql('ALTER TABLE tag_label ADD CONSTRAINT FK_2C4B49EE8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC9426AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabularies (id)');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC9426C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_label DROP FOREIGN KEY FK_2C4B49EEB213FA4');
        $this->addSql('ALTER TABLE resource_tags DROP FOREIGN KEY FK_609C349C8D7B4FB4');
        $this->addSql('ALTER TABLE tag_label DROP FOREIGN KEY FK_2C4B49EE8D7B4FB4');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC9426C54C8C93');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC9426AD0E05F6');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE resource_tags');
        $this->addSql('DROP TABLE tag_label');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE vocabularies');
    }
}
