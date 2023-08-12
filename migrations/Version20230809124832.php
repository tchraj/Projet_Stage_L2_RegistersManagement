<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809124832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9275ED078');
        $this->addSql('DROP INDEX IDX_F804D3B9275ED078 ON employe');
        $this->addSql('ALTER TABLE employe DROP profil_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_F804D3B9275ED078 ON employe (profil_id)');
    }
}
