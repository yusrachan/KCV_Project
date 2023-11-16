<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116082427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, kine_dispo_id INT NOT NULL, date_disponible DATE NOT NULL, background_color VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, border_color VARCHAR(255) NOT NULL, INDEX IDX_2CBACE2FF9C4AEB (kine_dispo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kinesitherapeute (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, kinesitherapeute_id INT NOT NULL, patient_id INT NOT NULL, heure_debut_id INT NOT NULL, date_heure_debut DATETIME NOT NULL, INDEX IDX_65E8AA0A3B67E217 (kinesitherapeute_id), INDEX IDX_65E8AA0A6B899279 (patient_id), INDEX IDX_65E8AA0A791DFAD4 (heure_debut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tranche_horaire (id INT AUTO_INCREMENT NOT NULL, heure_debut TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tranche_horaire_disponibilite (tranche_horaire_id INT NOT NULL, disponibilite_id INT NOT NULL, INDEX IDX_77D033969832F6F (tranche_horaire_id), INDEX IDX_77D03392B9D6493 (disponibilite_id), PRIMARY KEY(tranche_horaire_id, disponibilite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FF9C4AEB FOREIGN KEY (kine_dispo_id) REFERENCES kinesitherapeute (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A3B67E217 FOREIGN KEY (kinesitherapeute_id) REFERENCES kinesitherapeute (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A791DFAD4 FOREIGN KEY (heure_debut_id) REFERENCES tranche_horaire (id)');
        $this->addSql('ALTER TABLE tranche_horaire_disponibilite ADD CONSTRAINT FK_77D033969832F6F FOREIGN KEY (tranche_horaire_id) REFERENCES tranche_horaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tranche_horaire_disponibilite ADD CONSTRAINT FK_77D03392B9D6493 FOREIGN KEY (disponibilite_id) REFERENCES disponibilite (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FF9C4AEB');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A3B67E217');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B899279');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A791DFAD4');
        $this->addSql('ALTER TABLE tranche_horaire_disponibilite DROP FOREIGN KEY FK_77D033969832F6F');
        $this->addSql('ALTER TABLE tranche_horaire_disponibilite DROP FOREIGN KEY FK_77D03392B9D6493');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP TABLE kinesitherapeute');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE test_evenement');
        $this->addSql('DROP TABLE tranche_horaire');
        $this->addSql('DROP TABLE tranche_horaire_disponibilite');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
