<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406110145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE folder (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) NOT NULL, picture_1 VARCHAR(255) NOT NULL, picture_2 VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, exported TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder_option (folder_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BF3E7AC6162CB942 (folder_id), INDEX IDX_BF3E7AC6A7C41D6F (option_id), PRIMARY KEY(folder_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE folder_option ADD CONSTRAINT FK_BF3E7AC6162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE folder_option ADD CONSTRAINT FK_BF3E7AC6A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder_option DROP FOREIGN KEY FK_BF3E7AC6162CB942');
        $this->addSql('ALTER TABLE folder_option DROP FOREIGN KEY FK_BF3E7AC6A7C41D6F');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE folder_option');
        $this->addSql('DROP TABLE `option`');
    }
}
