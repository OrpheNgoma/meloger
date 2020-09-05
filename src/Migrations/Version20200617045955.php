<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617045955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, surface INT DEFAULT NULL, rooms INT NOT NULL, bedrooms INT DEFAULT NULL, floor INT DEFAULT NULL, price INT NOT NULL, cold INT DEFAULT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, charge VARCHAR(255) DEFAULT NULL, release_date DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8BF21CDE7E3C61F9 (owner_id), INDEX IDX_8BF21CDE12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `condition` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_property (condition_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_ACB4CEC7887793B6 (condition_id), INDEX IDX_ACB4CEC7549213EC (property_id), PRIMARY KEY(condition_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_property (tag_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_BDC36705BAD26311 (tag_id), INDEX IDX_BDC36705549213EC (property_id), PRIMARY KEY(tag_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_property (option_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_AB856D7AA7C41D6F (option_id), INDEX IDX_AB856D7A549213EC (property_id), PRIMARY KEY(option_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fonction_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64957889920 (fonction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE condition_property ADD CONSTRAINT FK_ACB4CEC7887793B6 FOREIGN KEY (condition_id) REFERENCES `condition` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE condition_property ADD CONSTRAINT FK_ACB4CEC7549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_property ADD CONSTRAINT FK_BDC36705BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_property ADD CONSTRAINT FK_BDC36705549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7AA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7A549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64957889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_property DROP FOREIGN KEY FK_ACB4CEC7549213EC');
        $this->addSql('ALTER TABLE tag_property DROP FOREIGN KEY FK_BDC36705549213EC');
        $this->addSql('ALTER TABLE option_property DROP FOREIGN KEY FK_AB856D7A549213EC');
        $this->addSql('ALTER TABLE condition_property DROP FOREIGN KEY FK_ACB4CEC7887793B6');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE12469DE2');
        $this->addSql('ALTER TABLE tag_property DROP FOREIGN KEY FK_BDC36705BAD26311');
        $this->addSql('ALTER TABLE option_property DROP FOREIGN KEY FK_AB856D7AA7C41D6F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64957889920');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7E3C61F9');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE `condition`');
        $this->addSql('DROP TABLE condition_property');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_property');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_property');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE user');
    }
}
