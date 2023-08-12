<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809125316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_utilisateur ADD CONSTRAINT FK_310DE9E7275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_310DE9E7275ED078 ON compte_utilisateur (profil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur DROP FOREIGN KEY FK_310DE9E7275ED078');
        $this->addSql('DROP INDEX IDX_310DE9E7275ED078 ON compte_utilisateur');
        $this->addSql('ALTER TABLE compte_utilisateur DROP profil_id');
    }
}
