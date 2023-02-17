<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203104535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP title, CHANGE alt alt VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video DROP title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD title VARCHAR(60) NOT NULL, CHANGE alt alt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD title VARCHAR(60) NOT NULL');
    }
}
