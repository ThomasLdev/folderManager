<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007075017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couleur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE norlog_folder (id INT AUTO_INCREMENT NOT NULL, norlog_reference VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sku (id INT AUTO_INCREMENT NOT NULL, folder_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, taille_id INT DEFAULT NULL, composition_id INT DEFAULT NULL, couleur_id INT DEFAULT NULL, designation_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, sku VARCHAR(255) NOT NULL, picture_1 VARCHAR(255) NOT NULL, picture_2 VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, exported TINYINT(1) NOT NULL, INDEX IDX_F9038C4162CB942 (folder_id), INDEX IDX_F9038C44827B9B2 (marque_id), INDEX IDX_F9038C4FF25611A (taille_id), INDEX IDX_F9038C487A2E12 (composition_id), INDEX IDX_F9038C4C31BA576 (couleur_id), INDEX IDX_F9038C4FAC7D83F (designation_id), INDEX IDX_F9038C4D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4162CB942 FOREIGN KEY (folder_id) REFERENCES norlog_folder (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C487A2E12 FOREIGN KEY (composition_id) REFERENCES composition (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id)');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C487A2E12');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4C31BA576');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4FAC7D83F');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4D5E86FF');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C44827B9B2');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4162CB942');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4FF25611A');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE couleur');
        $this->addSql('DROP TABLE designation');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE norlog_folder');
        $this->addSql('DROP TABLE sku');
        $this->addSql('DROP TABLE taille');
    }
}
