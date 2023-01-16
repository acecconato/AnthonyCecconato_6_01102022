<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112145054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `group` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', label VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(60) NOT NULL, alt VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(30) NOT NULL, cover VARCHAR(255) NOT NULL, description TEXT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D8F0A91EF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_group (trick_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_A6EF447AB281BE2E (trick_id), INDEX IDX_A6EF447AFE54D947 (group_id), PRIMARY KEY(trick_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick_group ADD CONSTRAINT FK_A6EF447AB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_group ADD CONSTRAINT FK_A6EF447AFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EF675F31B');
        $this->addSql('ALTER TABLE trick_group DROP FOREIGN KEY FK_A6EF447AB281BE2E');
        $this->addSql('ALTER TABLE trick_group DROP FOREIGN KEY FK_A6EF447AFE54D947');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_group');
        $this->addSql('DROP TABLE video');
    }
}
