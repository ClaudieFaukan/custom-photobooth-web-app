<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913082934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_profil_user ADD user_propriety_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE custom_profil_user ADD CONSTRAINT FK_B3F773618255F88A FOREIGN KEY (user_propriety_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B3F773618255F88A ON custom_profil_user (user_propriety_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE custom_profil_user DROP CONSTRAINT FK_B3F773618255F88A');
        $this->addSql('DROP INDEX IDX_B3F773618255F88A');
        $this->addSql('ALTER TABLE custom_profil_user DROP user_propriety_id');
    }
}
