<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913082605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_of_client ADD user_propriety_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_of_client ADD CONSTRAINT FK_D0AC42AB8255F88A FOREIGN KEY (user_propriety_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D0AC42AB8255F88A ON user_of_client (user_propriety_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_of_client DROP CONSTRAINT FK_D0AC42AB8255F88A');
        $this->addSql('DROP INDEX IDX_D0AC42AB8255F88A');
        $this->addSql('ALTER TABLE user_of_client DROP user_propriety_id');
    }
}
