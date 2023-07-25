<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720184415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_piece DROP FOREIGN KEY FK_4AC68CD476C50E4A');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP INDEX IDX_4AC68CD476C50E4A ON type_piece');
        $this->addSql('ALTER TABLE type_piece ADD employe_id INT DEFAULT NULL, CHANGE proprietaire_id visiteur_externe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_piece ADD CONSTRAINT FK_4AC68CD48B452EE8 FOREIGN KEY (visiteur_externe_id) REFERENCES visiteur_externe (id)');
        $this->addSql('ALTER TABLE type_piece ADD CONSTRAINT FK_4AC68CD41B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_4AC68CD48B452EE8 ON type_piece (visiteur_externe_id)');
        $this->addSql('CREATE INDEX IDX_4AC68CD41B65292 ON type_piece (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenoms VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tel VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE type_piece DROP FOREIGN KEY FK_4AC68CD48B452EE8');
        $this->addSql('ALTER TABLE type_piece DROP FOREIGN KEY FK_4AC68CD41B65292');
        $this->addSql('DROP INDEX IDX_4AC68CD48B452EE8 ON type_piece');
        $this->addSql('DROP INDEX IDX_4AC68CD41B65292 ON type_piece');
        $this->addSql('ALTER TABLE type_piece ADD proprietaire_id INT DEFAULT NULL, DROP visiteur_externe_id, DROP employe_id');
        $this->addSql('ALTER TABLE type_piece ADD CONSTRAINT FK_4AC68CD476C50E4A FOREIGN KEY (proprietaire_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_4AC68CD476C50E4A ON type_piece (proprietaire_id)');
    }
}
