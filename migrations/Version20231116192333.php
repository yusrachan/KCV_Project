<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116192333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disponibilite ADD tranche_horaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2F69832F6F FOREIGN KEY (tranche_horaire_id) REFERENCES tranche_horaire (id)');
        $this->addSql('CREATE INDEX IDX_2CBACE2F69832F6F ON disponibilite (tranche_horaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2F69832F6F');
        $this->addSql('DROP INDEX IDX_2CBACE2F69832F6F ON disponibilite');
        $this->addSql('ALTER TABLE disponibilite DROP tranche_horaire_id');
    }
}
