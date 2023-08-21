<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820210035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAC1C5DC59');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAC4F4BC33');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA7220BD21');
        $this->addSql('DROP TABLE notification');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, employe_notifie_id INT DEFAULT NULL, emmeteur_id INT DEFAULT NULL, visite_id INT DEFAULT NULL, date_notif DATE DEFAULT NULL, heure_notif TIME NOT NULL, contenu VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_BF5476CAC1C5DC59 (visite_id), INDEX IDX_BF5476CAC4F4BC33 (employe_notifie_id), INDEX IDX_BF5476CA7220BD21 (emmeteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAC1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAC4F4BC33 FOREIGN KEY (employe_notifie_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA7220BD21 FOREIGN KEY (emmeteur_id) REFERENCES employe (id)');
    }
}
