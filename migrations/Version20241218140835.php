<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218140835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE fiche_intendance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE fiche_intendance (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, nom_representant_legal VARCHAR(255) NOT NULL, prenom_representant_legal VARCHAR(255) NOT NULL, adresse_representant_legal VARCHAR(255) NOT NULL, code_postal_ville_representant_legal VARCHAR(255) NOT NULL, telephone_representant_legal VARCHAR(255) NOT NULL, nom_employeur VARCHAR(255) NOT NULL, regime VARCHAR(255) DEFAULT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE fiche_intendance_id_seq CASCADE');
        $this->addSql('DROP TABLE fiche_intendance');
    }
}
