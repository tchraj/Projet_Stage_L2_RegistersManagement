<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816094629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_utilisateur ADD CONSTRAINT FK_310DE9E71B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_310DE9E71B65292 ON compte_utilisateur (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur DROP FOREIGN KEY FK_310DE9E71B65292');
        $this->addSql('DROP INDEX UNIQ_310DE9E71B65292 ON compte_utilisateur');
        $this->addSql('ALTER TABLE compte_utilisateur DROP employe_id');
    }
}
