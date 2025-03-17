<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312143033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE accede_eleve_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE accede_representant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE humain_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE label_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE adhesion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE classe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adhesion (id INT NOT NULL, accepted BOOLEAN NOT NULL, payment_method VARCHAR(255) DEFAULT NULL, image_rights BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE assurance_scolaire (id INT NOT NULL, nom VARCHAR(50) NOT NULL, addresse VARCHAR(50) DEFAULT NULL, numero_assurance VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE centre_securite_sociale (id INT NOT NULL, nom VARCHAR(50) NOT NULL, addresse VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE classe (id INT NOT NULL, anee INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE info_eleve (id INT NOT NULL, responsable_financier_id INT NOT NULL, secu_sociale_id INT DEFAULT NULL, anne_scolaire_un_id INT DEFAULT NULL, anne_scolaire_deux_id INT DEFAULT NULL, lvun_id INT NOT NULL, lvdeux_id INT DEFAULT NULL, medecin_traitant_id INT DEFAULT NULL, sexe_id INT NOT NULL, regime_id INT DEFAULT NULL, responsable_un_id INT DEFAULT NULL, responsable_deux_id INT DEFAULT NULL, assureur_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_de_naissance DATE DEFAULT NULL, classe VARCHAR(50) DEFAULT NULL, nationalite VARCHAR(50) DEFAULT NULL, departement VARCHAR(50) DEFAULT NULL, nom_contacte_urgence VARCHAR(50) DEFAULT NULL, numero_contacte_urgence VARCHAR(50) DEFAULT NULL, dernier_rappel_antitetanique DATE DEFAULT NULL, observations VARCHAR(500) DEFAULT NULL, etat_matrimoniale_parents VARCHAR(50) DEFAULT NULL, cheque BOOLEAN DEFAULT NULL, droit_image BOOLEAN DEFAULT NULL, redoublant BOOLEAN DEFAULT NULL, carte_vitale BYTEA DEFAULT NULL, photo_identite BYTEA DEFAULT NULL, immattriculation_veic VARCHAR(9) DEFAULT NULL, bourse BYTEA DEFAULT NULL, attestation_jdc BYTEA DEFAULT NULL, attestation_identite BYTEA DEFAULT NULL, attestation_reusite BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6F8C0026E8167FA ON info_eleve (responsable_financier_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002F866B8C0 ON info_eleve (secu_sociale_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6F8C002617AE26D ON info_eleve (anne_scolaire_un_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6F8C002C1EAFA03 ON info_eleve (anne_scolaire_deux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C0027FCAE49E ON info_eleve (lvun_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C0021718F3F8 ON info_eleve (lvdeux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002B572964A ON info_eleve (medecin_traitant_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002448F3B3C ON info_eleve (sexe_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C00235E7D534 ON info_eleve (regime_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002D47821D2 ON info_eleve (responsable_un_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002A0DA6E7C ON info_eleve (responsable_deux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C00280F7E20A ON info_eleve (assureur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6F8C002A76ED395 ON info_eleve (user_id)');
        $this->addSql('CREATE TABLE langues (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE medecin_traitant (id INT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(50) DEFAULT NULL, numero VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE regime_cantine (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE representant_legal (id INT NOT NULL, info_eleve_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone_perso VARCHAR(15) DEFAULT NULL, courriel VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(50) DEFAULT NULL, commune VARCHAR(50) DEFAULT NULL, telephone_fixe VARCHAR(15) DEFAULT NULL, telephone_pro VARCHAR(15) DEFAULT NULL, poste VARCHAR(50) DEFAULT NULL, nom_employeur VARCHAR(50) DEFAULT NULL, adresse_employeur VARCHAR(50) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51277FD31D59BCD8 ON representant_legal (info_eleve_id)');
        $this->addSql('CREATE TABLE resposable_financier (id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone_perso VARCHAR(15) DEFAULT NULL, courriel VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(50) DEFAULT NULL, commune VARCHAR(50) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, nom_employeur VARCHAR(50) DEFAULT NULL, adresse_employeur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE scolarite_anterieur (id INT NOT NULL, lvdeux_id INT DEFAULT NULL, lvun_id INT DEFAULT NULL, anne_scolaire VARCHAR(9) NOT NULL, classe VARCHAR(50) DEFAULT NULL, option VARCHAR(50) DEFAULT NULL, etablissement VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B9AF77C61718F3F8 ON scolarite_anterieur (lvdeux_id)');
        $this->addSql('CREATE INDEX IDX_B9AF77C67FCAE49E ON scolarite_anterieur (lvun_id)');
        $this->addSql('CREATE TABLE sexe (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0026E8167FA FOREIGN KEY (responsable_financier_id) REFERENCES resposable_financier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002F866B8C0 FOREIGN KEY (secu_sociale_id) REFERENCES centre_securite_sociale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002617AE26D FOREIGN KEY (anne_scolaire_un_id) REFERENCES scolarite_anterieur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002C1EAFA03 FOREIGN KEY (anne_scolaire_deux_id) REFERENCES scolarite_anterieur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0027FCAE49E FOREIGN KEY (lvun_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0021718F3F8 FOREIGN KEY (lvdeux_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002B572964A FOREIGN KEY (medecin_traitant_id) REFERENCES medecin_traitant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002448F3B3C FOREIGN KEY (sexe_id) REFERENCES sexe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C00235E7D534 FOREIGN KEY (regime_id) REFERENCES regime_cantine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002D47821D2 FOREIGN KEY (responsable_un_id) REFERENCES representant_legal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002A0DA6E7C FOREIGN KEY (responsable_deux_id) REFERENCES representant_legal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C00280F7E20A FOREIGN KEY (assureur_id) REFERENCES assurance_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representant_legal ADD CONSTRAINT FK_51277FD31D59BCD8 FOREIGN KEY (info_eleve_id) REFERENCES info_eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scolarite_anterieur ADD CONSTRAINT FK_B9AF77C61718F3F8 FOREIGN KEY (lvdeux_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scolarite_anterieur ADD CONSTRAINT FK_B9AF77C67FCAE49E FOREIGN KEY (lvun_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE adhesion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE classe_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE accede_eleve_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE accede_representant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE humain_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE label_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0026E8167FA');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002F866B8C0');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002617AE26D');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002C1EAFA03');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0027FCAE49E');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0021718F3F8');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002B572964A');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002448F3B3C');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C00235E7D534');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002D47821D2');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002A0DA6E7C');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C00280F7E20A');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002A76ED395');
        $this->addSql('ALTER TABLE representant_legal DROP CONSTRAINT FK_51277FD31D59BCD8');
        $this->addSql('ALTER TABLE scolarite_anterieur DROP CONSTRAINT FK_B9AF77C61718F3F8');
        $this->addSql('ALTER TABLE scolarite_anterieur DROP CONSTRAINT FK_B9AF77C67FCAE49E');
        $this->addSql('DROP TABLE adhesion');
        $this->addSql('DROP TABLE assurance_scolaire');
        $this->addSql('DROP TABLE centre_securite_sociale');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE info_eleve');
        $this->addSql('DROP TABLE langues');
        $this->addSql('DROP TABLE medecin_traitant');
        $this->addSql('DROP TABLE regime_cantine');
        $this->addSql('DROP TABLE representant_legal');
        $this->addSql('DROP TABLE resposable_financier');
        $this->addSql('DROP TABLE scolarite_anterieur');
        $this->addSql('DROP TABLE sexe');
        $this->addSql('DROP TABLE "user"');
    }
}
