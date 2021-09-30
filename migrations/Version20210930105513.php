<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930105513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE value (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1D775834C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D775834C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE `option` ADD type_id INT NOT NULL, ADD value_id INT NOT NULL, DROP type, DROP value');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0F920BBA2 FOREIGN KEY (value_id) REFERENCES value (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B0C54C8C93 ON `option` (type_id)');
        $this->addSql('CREATE INDEX IDX_5A8600B0F920BBA2 ON `option` (value_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0C54C8C93');
        $this->addSql('ALTER TABLE value DROP FOREIGN KEY FK_1D775834C54C8C93');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0F920BBA2');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE value');
        $this->addSql('DROP INDEX IDX_5A8600B0C54C8C93 ON `option`');
        $this->addSql('DROP INDEX IDX_5A8600B0F920BBA2 ON `option`');
        $this->addSql('ALTER TABLE `option` ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP type_id, DROP value_id');
    }
}
