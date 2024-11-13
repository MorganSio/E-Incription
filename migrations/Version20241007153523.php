<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007153523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE accede_eleve_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE accede_representant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE assurance_scolaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE centre_securite_sociale_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE humain_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE info_eleve_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE label_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE langues_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medecin_traitant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE regime_cantine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE representant_legal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resposable_financier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE scolarite_anterieur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sexe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE accede_eleve (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE accede_representant (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE assurance_scolaire (id INT NOT NULL, nom VARCHAR(50) NOT NULL, addresse VARCHAR(50) DEFAULT NULL, numero_assurance VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE centre_securite_sociale (id INT NOT NULL, nom VARCHAR(50) NOT NULL, addresse VARCHAR(50) DEFAULT NULL, numero_assurance VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE humain (id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone_perso VARCHAR(15) DEFAULT NULL, courriel VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(50) DEFAULT NULL, commune VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE info_eleve (id INT NOT NULL, responsable_financier_id INT NOT NULL, secu_sociale_id INT DEFAULT NULL, anne_scolaire_un_id INT DEFAULT NULL, anne_scolaire_deux_id INT DEFAULT NULL, lvun_id INT NOT NULL, lvdeux_id INT DEFAULT NULL, medecin_traitant_id INT DEFAULT NULL, sexee_id INT NOT NULL, regime_id INT DEFAULT NULL, responsable_un_id INT DEFAULT NULL, responsable_deux_id INT DEFAULT NULL, assureur_id INT DEFAULT NULL, accede_eleve_id INT NOT NULL, date_de_naissance DATE DEFAULT NULL, classe VARCHAR(50) DEFAULT NULL, nationalite VARCHAR(50) DEFAULT NULL, departement VARCHAR(50) DEFAULT NULL, nom_contacte_urgence VARCHAR(50) DEFAULT NULL, numero_contacte_urgence VARCHAR(50) DEFAULT NULL, dernier_rappel_antitetanique DATE DEFAULT NULL, observations VARCHAR(500) DEFAULT NULL, etat_matrimoniale_parents VARCHAR(50) DEFAULT NULL, cheque BOOLEAN DEFAULT NULL, droit_image BOOLEAN DEFAULT NULL, redoublant BOOLEAN DEFAULT NULL, carte_vitale BYTEA DEFAULT NULL, photo_identite BYTEA DEFAULT NULL, immattriculation_veic VARCHAR(9) DEFAULT NULL, bourse BYTEA DEFAULT NULL, attestation_jdc BYTEA DEFAULT NULL, attestation_identite BYTEA DEFAULT NULL, attestation_reusite BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6F8C0026E8167FA ON info_eleve (responsable_financier_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002F866B8C0 ON info_eleve (secu_sociale_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6F8C002617AE26D ON info_eleve (anne_scolaire_un_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6F8C002C1EAFA03 ON info_eleve (anne_scolaire_deux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C0027FCAE49E ON info_eleve (lvun_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C0021718F3F8 ON info_eleve (lvdeux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002B572964A ON info_eleve (medecin_traitant_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002BD2846DA ON info_eleve (sexee_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C00235E7D534 ON info_eleve (regime_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002D47821D2 ON info_eleve (responsable_un_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002A0DA6E7C ON info_eleve (responsable_deux_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C00280F7E20A ON info_eleve (assureur_id)');
        $this->addSql('CREATE INDEX IDX_E6F8C002CA042664 ON info_eleve (accede_eleve_id)');
        $this->addSql('CREATE TABLE label (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE langues (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE medecin_traitant (id INT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(50) DEFAULT NULL, numero VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE regime_cantine (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE representant_legal (id INT NOT NULL, accede_representant_id INT NOT NULL, telephone_fixe VARCHAR(15) DEFAULT NULL, telephone_pro VARCHAR(15) DEFAULT NULL, poste VARCHAR(50) DEFAULT NULL, nom_employeur VARCHAR(50) DEFAULT NULL, adresse_employeur VARCHAR(50) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51277FD3A64E7E22 ON representant_legal (accede_representant_id)');
        $this->addSql('CREATE TABLE resposable_financier (id INT NOT NULL, rib VARCHAR(255) DEFAULT NULL, nom_employeur VARCHAR(50) DEFAULT NULL, adresse_employeur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE scolarite_anterieur (id INT NOT NULL, lvdeux_id INT DEFAULT NULL, lvun_id INT DEFAULT NULL, anne_scolaire VARCHAR(9) NOT NULL, classe VARCHAR(50) DEFAULT NULL, option VARCHAR(50) DEFAULT NULL, etablissement VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B9AF77C61718F3F8 ON scolarite_anterieur (lvdeux_id)');
        $this->addSql('CREATE INDEX IDX_B9AF77C67FCAE49E ON scolarite_anterieur (lvun_id)');
        $this->addSql('CREATE TABLE sexe (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_user (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, role_id INT NOT NULL, accede_eleve_id INT NOT NULL, accede_representant_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CA042664 ON "user" (accede_eleve_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A64E7E22 ON "user" (accede_representant_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0026E8167FA FOREIGN KEY (responsable_financier_id) REFERENCES resposable_financier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002F866B8C0 FOREIGN KEY (secu_sociale_id) REFERENCES centre_securite_sociale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002617AE26D FOREIGN KEY (anne_scolaire_un_id) REFERENCES scolarite_anterieur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002C1EAFA03 FOREIGN KEY (anne_scolaire_deux_id) REFERENCES scolarite_anterieur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0027FCAE49E FOREIGN KEY (lvun_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C0021718F3F8 FOREIGN KEY (lvdeux_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002B572964A FOREIGN KEY (medecin_traitant_id) REFERENCES medecin_traitant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002BD2846DA FOREIGN KEY (sexee_id) REFERENCES sexe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C00235E7D534 FOREIGN KEY (regime_id) REFERENCES regime_cantine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002D47821D2 FOREIGN KEY (responsable_un_id) REFERENCES representant_legal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002A0DA6E7C FOREIGN KEY (responsable_deux_id) REFERENCES representant_legal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C00280F7E20A FOREIGN KEY (assureur_id) REFERENCES assurance_scolaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE info_eleve ADD CONSTRAINT FK_E6F8C002CA042664 FOREIGN KEY (accede_eleve_id) REFERENCES accede_eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representant_legal ADD CONSTRAINT FK_51277FD3A64E7E22 FOREIGN KEY (accede_representant_id) REFERENCES accede_representant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scolarite_anterieur ADD CONSTRAINT FK_B9AF77C61718F3F8 FOREIGN KEY (lvdeux_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scolarite_anterieur ADD CONSTRAINT FK_B9AF77C67FCAE49E FOREIGN KEY (lvun_id) REFERENCES langues (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES type_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CA042664 FOREIGN KEY (accede_eleve_id) REFERENCES accede_eleve (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649A64E7E22 FOREIGN KEY (accede_representant_id) REFERENCES accede_representant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE accede_eleve_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE accede_representant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE assurance_scolaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE centre_securite_sociale_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE humain_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE info_eleve_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE label_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE langues_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medecin_traitant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE regime_cantine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE representant_legal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resposable_financier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE scolarite_anterieur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sexe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0026E8167FA');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002F866B8C0');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002617AE26D');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002C1EAFA03');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0027FCAE49E');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C0021718F3F8');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002B572964A');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002BD2846DA');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C00235E7D534');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002D47821D2');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002A0DA6E7C');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C00280F7E20A');
        $this->addSql('ALTER TABLE info_eleve DROP CONSTRAINT FK_E6F8C002CA042664');
        $this->addSql('ALTER TABLE representant_legal DROP CONSTRAINT FK_51277FD3A64E7E22');
        $this->addSql('ALTER TABLE scolarite_anterieur DROP CONSTRAINT FK_B9AF77C61718F3F8');
        $this->addSql('ALTER TABLE scolarite_anterieur DROP CONSTRAINT FK_B9AF77C67FCAE49E');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CA042664');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649A64E7E22');
        $this->addSql('DROP TABLE accede_eleve');
        $this->addSql('DROP TABLE accede_representant');
        $this->addSql('DROP TABLE assurance_scolaire');
        $this->addSql('DROP TABLE centre_securite_sociale');
        $this->addSql('DROP TABLE humain');
        $this->addSql('DROP TABLE info_eleve');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE langues');
        $this->addSql('DROP TABLE medecin_traitant');
        $this->addSql('DROP TABLE regime_cantine');
        $this->addSql('DROP TABLE representant_legal');
        $this->addSql('DROP TABLE resposable_financier');
        $this->addSql('DROP TABLE scolarite_anterieur');
        $this->addSql('DROP TABLE sexe');
        $this->addSql('DROP TABLE type_user');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
