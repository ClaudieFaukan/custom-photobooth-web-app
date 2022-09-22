<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920151528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_format ADD user_of_client_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE template_format ADD CONSTRAINT FK_D5527B2DAE43B525 FOREIGN KEY (user_of_client_id) REFERENCES user_of_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('CREATE INDEX IDX_D5527B2DAE43B525 ON template_format (user_of_client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        //$this->addSql('ALTER TABLE template_format DROP CONSTRAINT FK_D5527B2DAE43B525');
        //$this->addSql('DROP INDEX IDX_D5527B2DAE43B525');
        //$this->addSql('ALTER TABLE template_format DROP user_of_client_id');
    }
}
