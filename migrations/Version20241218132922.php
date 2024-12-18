<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218132922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT fk_e6f8c0028f5ea509');
        $this->addSql('DROP SEQUENCE classe_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE adhesion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE label_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adhesion (id INT NOT NULL, accepted BOOLEAN NOT NULL, payment_method VARCHAR(255) DEFAULT NULL, image_rights BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE label (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_user (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE classe');
        $this->addSql('ALTER TABLE centre_securite_sociale ADD numero_assurance VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_e6f8c0028f5ea509');
        $this->addSql('ALTER TABLE info_eleve ADD classe VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE info_eleve DROP classe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE adhesion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE label_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE classe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classe (id INT NOT NULL, anee INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE adhesion');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE type_user');
        $this->addSql('ALTER TABLE centre_securite_sociale DROP numero_assurance');
        $this->addSql('ALTER TABLE info_eleve ADD classe_id INT NOT NULL');
        $this->addSql('ALTER TABLE info_eleve DROP classe');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT fk_e6f8c0028f5ea509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e6f8c0028f5ea509 ON info_eleve (classe_id)');
    }
}
