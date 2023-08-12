<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809122523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur DROP FOREIGN KEY FK_310DE9E7275ED078');
        $this->addSql('DROP INDEX UNIQ_310DE9E7E7927C74 ON compte_utilisateur');
        $this->addSql('DROP INDEX IDX_310DE9E7275ED078 ON compte_utilisateur');
        $this->addSql('ALTER TABLE compte_utilisateur DROP profil_id, DROP is_verified, DROP reset_token, CHANGE email username VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_310DE9E7F85E0677 ON compte_utilisateur (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_310DE9E7F85E0677 ON compte_utilisateur');
        $this->addSql('ALTER TABLE compte_utilisateur ADD profil_id INT DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD reset_token VARCHAR(100) DEFAULT NULL, CHANGE username email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE compte_utilisateur ADD CONSTRAINT FK_310DE9E7275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_310DE9E7E7927C74 ON compte_utilisateur (email)');
        $this->addSql('CREATE INDEX IDX_310DE9E7275ED078 ON compte_utilisateur (profil_id)');
    }
}
