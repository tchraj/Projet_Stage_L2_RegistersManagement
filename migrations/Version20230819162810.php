<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819162810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD emmeteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA7220BD21 FOREIGN KEY (emmeteur_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA7220BD21 ON notification (emmeteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA7220BD21');
        $this->addSql('DROP INDEX IDX_BF5476CA7220BD21 ON notification');
        $this->addSql('ALTER TABLE notification DROP emmeteur_id');
    }
}
