<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210921093151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skus_folders (sku_id INT NOT NULL, norlog_folder_id INT NOT NULL, INDEX IDX_6DE7D8C01777D41C (sku_id), INDEX IDX_6DE7D8C0E795A2A1 (norlog_folder_id), PRIMARY KEY(sku_id, norlog_folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skus_folders ADD CONSTRAINT FK_6DE7D8C01777D41C FOREIGN KEY (sku_id) REFERENCES sku (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skus_folders ADD CONSTRAINT FK_6DE7D8C0E795A2A1 FOREIGN KEY (norlog_folder_id) REFERENCES norlog_folder (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE skus_folders');
    }
}
