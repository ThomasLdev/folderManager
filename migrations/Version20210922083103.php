<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922083103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE norlog_folder (id INT AUTO_INCREMENT NOT NULL, norlog_reference VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sku (id INT AUTO_INCREMENT NOT NULL, folder_id INT DEFAULT NULL, sku VARCHAR(255) NOT NULL, picture_1 VARCHAR(255) NOT NULL, picture_2 VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, exported TINYINT(1) NOT NULL, INDEX IDX_F9038C4162CB942 (folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sku_option (sku_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_FAABEE2D1777D41C (sku_id), INDEX IDX_FAABEE2DA7C41D6F (option_id), PRIMARY KEY(sku_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C4162CB942 FOREIGN KEY (folder_id) REFERENCES norlog_folder (id)');
        $this->addSql('ALTER TABLE sku_option ADD CONSTRAINT FK_FAABEE2D1777D41C FOREIGN KEY (sku_id) REFERENCES sku (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sku_option ADD CONSTRAINT FK_FAABEE2DA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C4162CB942');
        $this->addSql('ALTER TABLE sku_option DROP FOREIGN KEY FK_FAABEE2DA7C41D6F');
        $this->addSql('ALTER TABLE sku_option DROP FOREIGN KEY FK_FAABEE2D1777D41C');
        $this->addSql('DROP TABLE norlog_folder');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE sku');
        $this->addSql('DROP TABLE sku_option');
    }
}
