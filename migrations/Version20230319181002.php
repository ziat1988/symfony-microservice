<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319181002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_promotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE promotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product_promotion (id INT NOT NULL, product_id INT NOT NULL, promotion_id INT NOT NULL, valid_to TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, valid_from TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AFBDCB5C4584665A ON product_promotion (product_id)');
        $this->addSql('CREATE INDEX IDX_AFBDCB5C139DF194 ON product_promotion (promotion_id)');
        $this->addSql('CREATE TABLE promotion (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, adjustment DOUBLE PRECISION NOT NULL, criteria JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_promotion ADD CONSTRAINT FK_AFBDCB5C139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_promotion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE promotion_id_seq CASCADE');
        $this->addSql('ALTER TABLE product_promotion DROP CONSTRAINT FK_AFBDCB5C4584665A');
        $this->addSql('ALTER TABLE product_promotion DROP CONSTRAINT FK_AFBDCB5C139DF194');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_promotion');
        $this->addSql('DROP TABLE promotion');
    }
}
