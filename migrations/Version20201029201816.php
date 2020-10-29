<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029201816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE age_range ADD plural_name VARCHAR(50) NOT NULL, CHANGE name singular_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE camp ADD age_range_id INT NOT NULL');
        $this->addSql('ALTER TABLE camp ADD CONSTRAINT FK_C194423064482BF8 FOREIGN KEY (age_range_id) REFERENCES age_range (id)');
        $this->addSql('CREATE INDEX IDX_C194423064482BF8 ON camp (age_range_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE age_range ADD name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP singular_name, DROP plural_name');
        $this->addSql('ALTER TABLE camp DROP FOREIGN KEY FK_C194423064482BF8');
        $this->addSql('DROP INDEX IDX_C194423064482BF8 ON camp');
        $this->addSql('ALTER TABLE camp DROP age_range_id');
    }
}
