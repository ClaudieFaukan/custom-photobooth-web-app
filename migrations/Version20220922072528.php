<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922072528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_format DROP CONSTRAINT fk_d5527b2dae43b525');
        $this->addSql('DROP INDEX idx_d5527b2dae43b525');
        $this->addSql('ALTER TABLE template_format DROP user_of_client_id');
        $this->addSql('ALTER TABLE user_of_client ADD template_format_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_of_client ADD CONSTRAINT FK_D0AC42AB1F7A80B3 FOREIGN KEY (template_format_id) REFERENCES template_format (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D0AC42AB1F7A80B3 ON user_of_client (template_format_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_of_client DROP CONSTRAINT FK_D0AC42AB1F7A80B3');
        $this->addSql('DROP INDEX IDX_D0AC42AB1F7A80B3');
        $this->addSql('ALTER TABLE user_of_client DROP template_format_id');
        $this->addSql('ALTER TABLE template_format ADD user_of_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE template_format ADD CONSTRAINT fk_d5527b2dae43b525 FOREIGN KEY (user_of_client_id) REFERENCES user_of_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d5527b2dae43b525 ON template_format (user_of_client_id)');
    }
}
