<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427141030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, commentaire VARCHAR(255) NOT NULL, created_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture CHANGE rev_ID rev_ID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guide DROP FOREIGN KEY Fk_vols_guide');
        $this->addSql('ALTER TABLE guide CHANGE id_vol id_vol INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guide ADD CONSTRAINT FK_CA9EC73597F87FB1 FOREIGN KEY (id_vol) REFERENCES vol (Vol_id)');
        $this->addSql('ALTER TABLE infousersondg CHANGE sondage_id sondage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE logger CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY questions_ibfk_1');
        $this->addSql('ALTER TABLE questions CHANGE sondage_id sondage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondage (sondage_id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reclamation CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955CEA2F6E1 FOREIGN KEY (ID_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE réponses DROP FOREIGN KEY réponses_ibfk_1');
        $this->addSql('ALTER TABLE réponses CHANGE Question_id Question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE réponses ADD CONSTRAINT FK_52CE2D9498BB7968 FOREIGN KEY (Question_id) REFERENCES questions (Question_id)');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY transport_ibfk_1');
        $this->addSql('ALTER TABLE transport CHANGE Hebergement_id Hebergement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212EEEDF77BE FOREIGN KEY (Hebergement_id) REFERENCES hebergement (Hebergement_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY ck');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494103C75F FOREIGN KEY (id_offre) REFERENCES offres (ID_off)');
        $this->addSql('ALTER TABLE voyageorganise DROP FOREIGN KEY t_ck');
        $this->addSql('ALTER TABLE voyageorganise DROP FOREIGN KEY vol_ck');
        $this->addSql('ALTER TABLE voyageorganise CHANGE Vol_id Vol_id INT DEFAULT NULL, CHANGE Transport_id Transport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyageorganise ADD CONSTRAINT FK_81497A579887FE4C FOREIGN KEY (Vol_id) REFERENCES vol (Vol_id)');
        $this->addSql('ALTER TABLE voyageorganise ADD CONSTRAINT FK_81497A5781381AC7 FOREIGN KEY (Transport_id) REFERENCES transport (Transport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE feedback');
        $this->addSql('ALTER TABLE cours CHANGE Type Type VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Titre Titre VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Contenu Contenu TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE exercices CHANGE Type Type VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Question Question VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Reponse Reponse VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Hint Hint VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE facture CHANGE Etat Etat VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE rev_ID rev_ID INT NOT NULL');
        $this->addSql('ALTER TABLE guide DROP FOREIGN KEY FK_CA9EC73597F87FB1');
        $this->addSql('ALTER TABLE guide CHANGE id_vol id_vol INT NOT NULL, CHANGE Titre Titre VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Pays Pays VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE guide ADD CONSTRAINT Fk_vols_guide FOREIGN KEY (id_vol) REFERENCES vol (Vol_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hebergement CHANGE Description Description TEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Type Type VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Adresse Adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Image Image VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE infousersondg CHANGE sondage_id sondage_id INT NOT NULL, CHANGE sexe sexe VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pay pay VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE logger CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE offres CHANGE Description Description TEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE Destination Destination VARCHAR(250) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE paiement CHANGE Montant Montant TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE Mode_Pay Mode_Pay VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5BAF4AE56');
        $this->addSql('ALTER TABLE questions CHANGE sondage_id sondage_id INT NOT NULL, CHANGE question question VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE type type VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT questions_ibfk_1 FOREIGN KEY (sondage_id) REFERENCES sondage (sondage_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B3CA4B');
        $this->addSql('ALTER TABLE reclamation CHANGE id_user id_user INT NOT NULL, CHANGE description description TEXT NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955CEA2F6E1');
        $this->addSql('ALTER TABLE reservation CHANGE Type Type VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Destination Destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK FOREIGN KEY (ID_user) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE réponses DROP FOREIGN KEY FK_52CE2D9498BB7968');
        $this->addSql('ALTER TABLE réponses CHANGE réponse réponse VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Question_id Question_id INT NOT NULL');
        $this->addSql('ALTER TABLE réponses ADD CONSTRAINT réponses_ibfk_1 FOREIGN KEY (Question_id) REFERENCES questions (Question_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sondage CHANGE sujet sujet VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE catégorie catégorie VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212EEEDF77BE');
        $this->addSql('ALTER TABLE transport CHANGE Type Type VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Description Description TEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Image Image VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Hebergement_id Hebergement_id INT NOT NULL');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT transport_ibfk_1 FOREIGN KEY (Hebergement_id) REFERENCES hebergement (Hebergement_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494103C75F');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE prénom prénom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE sexe sexe VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE adresse adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE mot_de_passe mot_de_passe VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE role role VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT ck FOREIGN KEY (id_offre) REFERENCES offres (ID_off) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vol CHANGE Destination Destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Départ Départ VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Image Image VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE voyageorganise DROP FOREIGN KEY FK_81497A579887FE4C');
        $this->addSql('ALTER TABLE voyageorganise DROP FOREIGN KEY FK_81497A5781381AC7');
        $this->addSql('ALTER TABLE voyageorganise CHANGE Description Description TEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Image Image VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Vol_id Vol_id INT NOT NULL, CHANGE Transport_id Transport_id INT NOT NULL');
        $this->addSql('ALTER TABLE voyageorganise ADD CONSTRAINT t_ck FOREIGN KEY (Transport_id) REFERENCES transport (Transport_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyageorganise ADD CONSTRAINT vol_ck FOREIGN KEY (Vol_id) REFERENCES vol (Vol_id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
