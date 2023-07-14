<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230714115114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compte_utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(60) NOT NULL, password VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direction (id INT AUTO_INCREMENT NOT NULL, filiale_id INT DEFAULT NULL, nom_direction VARCHAR(100) DEFAULT NULL, INDEX IDX_3E4AD1B35C4BCADC (filiale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, direction_id INT DEFAULT NULL, compte_utilisateur_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenoms VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, tel VARCHAR(15) NOT NULL, is_verified TINYINT(1) NOT NULL, INDEX IDX_F804D3B9275ED078 (profil_id), INDEX IDX_F804D3B9AF73D997 (direction_id), INDEX IDX_F804D3B93BE1373C (compte_utilisateur_id), INDEX IDX_F804D3B91B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiale (id INT AUTO_INCREMENT NOT NULL, nom_filiale VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_role (profil_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_5F319A88275ED078 (profil_id), INDEX IDX_5F319A88D60322AC (role_id), PRIMARY KEY(profil_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(35) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, visiteur_externe_id INT DEFAULT NULL, employe_visiteur_id INT DEFAULT NULL, employe_visite_id INT DEFAULT NULL, date_visite DATE NOT NULL, heure_deb TIME NOT NULL, heure_fin TIME NOT NULL, motif LONGTEXT NOT NULL, etat_visite TINYINT(1) NOT NULL, INDEX IDX_B09C8CBB8B452EE8 (visiteur_externe_id), INDEX IDX_B09C8CBB7AF0ADF4 (employe_visiteur_id), INDEX IDX_B09C8CBBEBDA0F (employe_visite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiteur_externe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenoms VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, tel VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE direction ADD CONSTRAINT FK_3E4AD1B35C4BCADC FOREIGN KEY (filiale_id) REFERENCES filiale (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9AF73D997 FOREIGN KEY (direction_id) REFERENCES direction (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B93BE1373C FOREIGN KEY (compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B91B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE profil_role ADD CONSTRAINT FK_5F319A88275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_role ADD CONSTRAINT FK_5F319A88D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB8B452EE8 FOREIGN KEY (visiteur_externe_id) REFERENCES visiteur_externe (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB7AF0ADF4 FOREIGN KEY (employe_visiteur_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBEBDA0F FOREIGN KEY (employe_visite_id) REFERENCES employe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direction DROP FOREIGN KEY FK_3E4AD1B35C4BCADC');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9275ED078');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9AF73D997');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B93BE1373C');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B91B65292');
        $this->addSql('ALTER TABLE profil_role DROP FOREIGN KEY FK_5F319A88275ED078');
        $this->addSql('ALTER TABLE profil_role DROP FOREIGN KEY FK_5F319A88D60322AC');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB8B452EE8');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB7AF0ADF4');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBBEBDA0F');
        $this->addSql('DROP TABLE compte_utilisateur');
        $this->addSql('DROP TABLE direction');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE filiale');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_role');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE visiteur_externe');
    }
}
