<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026073623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tags_tag_label (tags_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tag_label_id INT NOT NULL, INDEX IDX_484A77B28D7B4FB4 (tags_id), INDEX IDX_484A77B258854E2 (tag_label_id), PRIMARY KEY(tags_id, tag_label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_tag_label ADD CONSTRAINT FK_484A77B28D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_tag_label ADD CONSTRAINT FK_484A77B258854E2 FOREIGN KEY (tag_label_id) REFERENCES tag_label (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tags_tag_label');
    }
}
