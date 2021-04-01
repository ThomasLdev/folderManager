<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325151605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE folder_option (folder_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BF3E7AC6162CB942 (folder_id), INDEX IDX_BF3E7AC6A7C41D6F (option_id), PRIMARY KEY(folder_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE folder_option ADD CONSTRAINT FK_BF3E7AC6162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE folder_option ADD CONSTRAINT FK_BF3E7AC6A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0162CB942');
        $this->addSql('DROP INDEX IDX_5A8600B0162CB942 ON `option`');
        $this->addSql('ALTER TABLE `option` DROP folder_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE folder_option');
        $this->addSql('ALTER TABLE `option` ADD folder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B0162CB942 ON `option` (folder_id)');
    }
}
