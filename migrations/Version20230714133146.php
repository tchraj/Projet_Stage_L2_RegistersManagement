<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230714133146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD is_verified TINYINT(1) NOT NULL, DROP nom_utilisateur, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_310DE9E7E7927C74 ON compte_utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_310DE9E7E7927C74 ON compte_utilisateur');
        $this->addSql('ALTER TABLE compte_utilisateur ADD nom_utilisateur VARCHAR(60) NOT NULL, DROP email, DROP roles, DROP is_verified, CHANGE password password VARCHAR(15) NOT NULL');
    }
}
