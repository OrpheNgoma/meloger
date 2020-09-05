<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620205840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE property_tag (property_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C1B5E350549213EC (property_id), INDEX IDX_C1B5E350BAD26311 (tag_id), PRIMARY KEY(property_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_condition (property_id INT NOT NULL, condition_id INT NOT NULL, INDEX IDX_CC398AFE549213EC (property_id), INDEX IDX_CC398AFE887793B6 (condition_id), PRIMARY KEY(property_id, condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_tag ADD CONSTRAINT FK_C1B5E350549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_tag ADD CONSTRAINT FK_C1B5E350BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_condition ADD CONSTRAINT FK_CC398AFE549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_condition ADD CONSTRAINT FK_CC398AFE887793B6 FOREIGN KEY (condition_id) REFERENCES `condition` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE condition_property');
        $this->addSql('DROP TABLE tag_property');
        $this->addSql('ALTER TABLE property ADD filename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE condition_property (condition_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_ACB4CEC7549213EC (property_id), INDEX IDX_ACB4CEC7887793B6 (condition_id), PRIMARY KEY(condition_id, property_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag_property (tag_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_BDC36705549213EC (property_id), INDEX IDX_BDC36705BAD26311 (tag_id), PRIMARY KEY(tag_id, property_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE condition_property ADD CONSTRAINT FK_ACB4CEC7549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE condition_property ADD CONSTRAINT FK_ACB4CEC7887793B6 FOREIGN KEY (condition_id) REFERENCES `condition` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_property ADD CONSTRAINT FK_BDC36705549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_property ADD CONSTRAINT FK_BDC36705BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE property_tag');
        $this->addSql('DROP TABLE property_condition');
        $this->addSql('ALTER TABLE property DROP filename');
    }
}
