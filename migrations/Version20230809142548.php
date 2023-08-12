<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809142548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur DROP roles');
        $this->addSql('ALTER TABLE direction ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE direction ADD CONSTRAINT FK_3E4AD1B353C59D72 FOREIGN KEY (responsable_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_3E4AD1B353C59D72 ON direction (responsable_id)');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B91B65292');
        $this->addSql('DROP INDEX IDX_F804D3B91B65292 ON employe');
        $this->addSql('ALTER TABLE employe DROP employe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE direction DROP FOREIGN KEY FK_3E4AD1B353C59D72');
        $this->addSql('DROP INDEX IDX_3E4AD1B353C59D72 ON direction');
        $this->addSql('ALTER TABLE direction DROP responsable_id');
        $this->addSql('ALTER TABLE employe ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B91B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_F804D3B91B65292 ON employe (employe_id)');
    }
}
