<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029190258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE age_range (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, min_age INT NOT NULL, max_age INT NOT NULL, nb_children_by_animator INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animator (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp_animator (camp_id INT NOT NULL, animator_id INT NOT NULL, INDEX IDX_CAC54D1477075ABB (camp_id), INDEX IDX_CAC54D1470FBD26D (animator_id), PRIMARY KEY(camp_id, animator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp_child (camp_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_2C8D3EB577075ABB (camp_id), INDEX IDX_2C8D3EB5DD62C21B (child_id), PRIMARY KEY(camp_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, age_range_id INT NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, birth_date DATE NOT NULL, INDEX IDX_22B3542964482BF8 (age_range_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camp_animator ADD CONSTRAINT FK_CAC54D1477075ABB FOREIGN KEY (camp_id) REFERENCES camp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camp_animator ADD CONSTRAINT FK_CAC54D1470FBD26D FOREIGN KEY (animator_id) REFERENCES animator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camp_child ADD CONSTRAINT FK_2C8D3EB577075ABB FOREIGN KEY (camp_id) REFERENCES camp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camp_child ADD CONSTRAINT FK_2C8D3EB5DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B3542964482BF8 FOREIGN KEY (age_range_id) REFERENCES age_range (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B3542964482BF8');
        $this->addSql('ALTER TABLE camp_animator DROP FOREIGN KEY FK_CAC54D1470FBD26D');
        $this->addSql('ALTER TABLE camp_animator DROP FOREIGN KEY FK_CAC54D1477075ABB');
        $this->addSql('ALTER TABLE camp_child DROP FOREIGN KEY FK_2C8D3EB577075ABB');
        $this->addSql('ALTER TABLE camp_child DROP FOREIGN KEY FK_2C8D3EB5DD62C21B');
        $this->addSql('DROP TABLE age_range');
        $this->addSql('DROP TABLE animator');
        $this->addSql('DROP TABLE camp');
        $this->addSql('DROP TABLE camp_animator');
        $this->addSql('DROP TABLE camp_child');
        $this->addSql('DROP TABLE child');
    }
}
