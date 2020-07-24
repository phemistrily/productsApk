<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724011433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock ADD product_owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3CB58C0B6E FOREIGN KEY (product_owner_id) REFERENCES product_owner (id)');
        $this->addSql('CREATE INDEX IDX_EA6A2D3CB58C0B6E ON product_stock (product_owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3CB58C0B6E');
        $this->addSql('DROP INDEX IDX_EA6A2D3CB58C0B6E ON product_stock');
        $this->addSql('ALTER TABLE product_stock DROP product_owner_id');
    }
}
